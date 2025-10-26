<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use OpenAI\Laravel\Facades\OpenAI;

class ContentController extends Controller
{
    public function index(): View
    {
        $contents = auth()->user()->contents()->latest()->paginate(10);
        return view('content.index', compact('contents'));
    }

    public function create(): View
    {
        $company = auth()->user()->company;
        return view('content.create', compact('company'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:blog,post,email,seo_page',
            'title' => 'required|string|max:255',
            'prompt' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        $subscription = $user->subscription;

        // Check if user has reached their limit
        if ($subscription && $subscription->hasReachedLimit()) {
            return back()->with('error', 'You have reached your monthly limit. Please upgrade your plan.');
        }

        try {
            // Get company information for context
            $company = $user->company;
            $context = '';
            
            if ($company) {
                $context = "Company: {$company->name}\n";
                $context .= "Industry: {$company->industry}\n";
                $context .= "Tone of voice: {$company->tone_of_voice}\n";
                if ($company->keywords) {
                    $context .= "Keywords to include: " . implode(', ', $company->keywords) . "\n";
                }
                $context .= "\n";
            }

            // Create the prompt based on content type
            $systemPrompt = $this->getSystemPrompt($request->type);
            $userPrompt = $context . "Title: " . $request->title . "\n\nPrompt: " . $request->prompt;

            // Call OpenAI API
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);

            $generatedContent = $response->choices[0]->message->content;

            // Save the content
            $content = Content::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'title' => $request->title,
                'body' => $generatedContent,
            ]);

            // Update subscription usage
            if ($subscription) {
                $subscription->increment('used');
            }

            return redirect()->route('content.show', $content)
                ->with('success', 'Content generated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate content: ' . $e->getMessage());
        }
    }

    public function show(Content $content): View
    {
        $this->authorize('view', $content);
        return view('content.show', compact('content'));
    }

    public function edit(Content $content): View
    {
        $this->authorize('update', $content);
        return view('content.edit', compact('content'));
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $this->authorize('update', $content);

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $content->update($request->only(['title', 'body']));

        return redirect()->route('content.show', $content)
            ->with('success', 'Content updated successfully!');
    }

    public function destroy(Content $content): RedirectResponse
    {
        $this->authorize('delete', $content);
        
        $content->delete();

        return redirect()->route('content.index')
            ->with('success', 'Content deleted successfully!');
    }

    private function getSystemPrompt(string $type): string
    {
        return match ($type) {
            'blog' => 'You are a professional blog writer for Dutch entrepreneurs. Write engaging, informative blog posts that provide value to business owners. Use a professional yet approachable tone. Structure your content with clear headings and paragraphs.',
            
            'post' => 'You are a social media content creator for Dutch entrepreneurs. Write engaging social media posts that are concise, attention-grabbing, and encourage engagement. Include relevant hashtags where appropriate.',
            
            'email' => 'You are a professional email marketing specialist for Dutch entrepreneurs. Write compelling email content that drives action. Include a clear subject line suggestion and structure the email with a strong opening, valuable content, and clear call-to-action.',
            
            'seo_page' => 'You are an SEO content specialist for Dutch entrepreneurs. Write SEO-optimized web page content that ranks well in search engines while providing value to readers. Include meta description suggestions and structure content with proper headings.',
            
            default => 'You are a professional content writer for Dutch entrepreneurs. Create high-quality, engaging content that serves the business needs of your audience.',
        };
    }
}
