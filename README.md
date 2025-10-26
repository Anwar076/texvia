# Texvia - AI Text Generation Platform

**Texvia** is a subscription-based AI text generation platform designed specifically for entrepreneurs in the Netherlands. Built with Laravel and powered by OpenAI's GPT-4o-mini, Texvia helps businesses create high-quality content including blog posts, social media posts, emails, and SEO pages.

## 🚀 Features

- **AI-Powered Content Generation**: Generate professional content using OpenAI GPT-4o-mini
- **Multiple Content Types**: Support for blogs, social posts, emails, and SEO pages
- **Company Profiles**: Personalized content based on your business information
- **Subscription Management**: Usage limits and plan management
- **User Authentication**: Secure user registration and login with Laravel Breeze
- **Responsive Design**: Modern, mobile-friendly interface with Tailwind CSS

## 🛠️ Technology Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: SQLite (easily configurable for other databases)
- **AI Integration**: OpenAI GPT-4o-mini via openai-php/laravel
- **Authentication**: Laravel Breeze

## 📋 Requirements

- PHP 8.4 or higher
- Composer
- SQLite (or other database)
- OpenAI API Key

## 🔧 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd texvia
```

### 2. Install Dependencies

```bash
composer install
npm install && npm run build
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Environment Variables

Edit the `.env` file and set the following:

```env
APP_NAME=Texvia
APP_URL=http://localhost:8000

# Database (SQLite is pre-configured)
DB_CONNECTION=sqlite

# OpenAI Configuration (REQUIRED)
OPENAI_API_KEY=your-openai-api-key-here
```

**⚠️ Important**: You must obtain an OpenAI API key from [OpenAI Platform](https://platform.openai.com/api-keys) and add it to your `.env` file.

### 5. Database Setup

```bash
touch database/database.sqlite
php artisan migrate
```

### 6. Create Test User (Optional)

```bash
php artisan db:seed --class=TestUserSeeder
```

This creates a test user:
- **Email**: test@texvia.com
- **Password**: password

### 7. Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 🎯 Usage

### Getting Started

1. **Register/Login**: Create an account or use the test credentials
2. **Setup Company Profile**: Configure your business information for personalized content
3. **Generate Content**: Choose content type and provide prompts
4. **Manage Content**: View, edit, and organize your generated content

### Content Types

- **Blog Posts**: Long-form articles for your website
- **Social Media Posts**: Engaging content for social platforms
- **Emails**: Marketing and communication emails
- **SEO Pages**: Search engine optimized web content

### Subscription Plans

- **Free Plan**: 10 generations per month
- **Pro Plan**: Extended limits (customizable)
- **Unlimited Plan**: No generation limits (customizable)

## 🏗️ Project Structure

### Models

- **User**: User authentication and profile
- **Company**: Business information for content personalization
- **Content**: Generated content storage
- **Subscription**: User subscription and usage tracking

### Key Controllers

- **DashboardController**: Main dashboard with statistics
- **ContentController**: Content generation and management
- **CompanyController**: Company profile management

### Database Schema

```sql
-- Companies table
- user_id (foreign key)
- name
- industry
- tone_of_voice
- keywords (JSON)

-- Contents table
- user_id (foreign key)
- type (blog, post, email, seo_page)
- title
- body (longText)

-- Subscriptions table
- user_id (foreign key)
- plan (free, pro, unlimited)
- limit (integer)
- used (integer, default 0)
- renew_date
```

## 🔑 OpenAI Integration

The application uses OpenAI's GPT-4o-mini model for content generation. Each content type has specialized system prompts:

- **Blog**: Professional, informative content for entrepreneurs
- **Social Post**: Engaging, concise social media content
- **Email**: Marketing emails with clear CTAs
- **SEO Page**: Search-optimized web content

## 🚦 API Configuration

### OpenAI Setup

1. Sign up at [OpenAI Platform](https://platform.openai.com/)
2. Generate an API key
3. Add the key to your `.env` file:

```env
OPENAI_API_KEY=sk-your-actual-api-key-here
```

### Usage Monitoring

The application tracks API usage per user and enforces subscription limits to control costs.

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

## 🔒 Security

- User authentication with Laravel Breeze
- Content ownership validation
- API key protection
- CSRF protection on all forms

## 📝 Development Notes

### Adding New Content Types

1. Update the `type` enum in the contents migration
2. Add the new type to the ContentController validation
3. Create a system prompt in `getSystemPrompt()` method
4. Update the UI components

### Customizing Subscription Plans

Modify the subscription limits in:
- DashboardController (default plan creation)
- Database seeder
- UI components

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Check the Laravel documentation
- Review OpenAI API documentation
- Create an issue in the repository

---

**Built with ❤️ for Dutch entrepreneurs**
