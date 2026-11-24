<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Site Settings
        Setting::create([
            'site_name'     => 'Alpha Mode Tech Blog',
            'contact_email' => 'contact@alphamode.dev',
            'description'   => 'A modern PHP & Laravel 11 Blog CMS built for TPL 6213 Programming Language.',
            'about'         => 'Welcome to Alpha Mode Tech Blog. We share practical guides on PHP 8, Laravel 11, MVC architecture, database design, and RESTful APIs.',
            'copy_rights'   => '© 2026 Group Alpha Mode. All rights reserved.',
            'url_fb'        => 'https://facebook.com',
            'url_twitter'   => 'https://twitter.com',
            'url_insta'     => 'https://instagram.com',
            'url_linkedin'  => 'https://linkedin.com',
        ]);

        // 2. Demo Accounts (Password for all: "password")
        $admin = User::factory()->create([
            'name'    => 'Admin',
            'email'   => 'admin@example.com',
            'role_id' => 1,
        ]);

        $writer = User::factory()->create([
            'name'    => 'Alex Writer',
            'email'   => 'writer@example.com',
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name'    => 'Reader User',
            'email'   => 'user@example.com',
            'role_id' => 3,
        ]);

        // 3. Categories
        $catPhp = Category::create([
            'user_id' => $admin->id,
            'name'    => 'PHP Basics',
            'slug'    => 'php-basics',
        ]);

        $catLaravel = Category::create([
            'user_id' => $admin->id,
            'name'    => 'Laravel Framework',
            'slug'    => 'laravel-framework',
        ]);

        $catSecurity = Category::create([
            'user_id' => $admin->id,
            'name'    => 'Web Security',
            'slug'    => 'web-security',
        ]);

        $catApi = Category::create([
            'user_id' => $admin->id,
            'name'    => 'REST API',
            'slug'    => 'rest-api',
        ]);

        // 4. Published English Posts
        $posts = [
            [
                'user_id'     => $admin->id,
                'category_id' => $catLaravel->id,
                'title'       => 'Getting Started with Laravel 11 MVC Architecture',
                'content'     => 'Laravel 11 follows the Model-View-Controller (MVC) architectural pattern, separating database logic, user interface templates, and request handling. This structure keeps modern PHP web applications clean, testable, and easy to scale.',
            ],
            [
                'user_id'     => $writer->id,
                'category_id' => $catPhp->id,
                'title'       => 'Why PHP 8 Remains Dominant in Modern Web Development',
                'content'     => 'With the introduction of the JIT compiler, union types, attributes, and match expressions, PHP 8 delivers strong performance and developer productivity. It powers over two-thirds of websites with a known server-side language.',
            ],
            [
                'user_id'     => $admin->id,
                'category_id' => $catSecurity->id,
                'title'       => 'Role-Based Access Control with Laravel Gates and Policies',
                'content'     => 'Securing an admin dashboard requires clear authorization rules. Laravel Gates and Policies let developers restrict routes and actions by user roles such as Admin, Writer, and User with minimal boilerplate code.',
            ],
            [
                'user_id'     => $writer->id,
                'category_id' => $catApi->id,
                'title'       => 'Building Clean JSON REST APIs in Laravel',
                'content'     => 'Laravel makes it straightforward to expose structured JSON endpoints using API routes, Eloquent resources, and built-in request validation. Clients can fetch posts and categories reliably with standard HTTP status codes.',
            ],
            [
                'user_id'     => $admin->id,
                'category_id' => $catLaravel->id,
                'title'       => 'Mastering Eloquent ORM Relationships and Migrations',
                'content'     => 'Eloquent ORM maps database tables directly to PHP classes. Defining One-to-Many, Many-to-Many, and Polymorphic relationships allows developers to query complex relational data using expressive, readable syntax.',
            ],
            [
                'user_id'     => $writer->id,
                'category_id' => $catSecurity->id,
                'title'       => 'Server-Side Form Validation and Error Handling Best Practices',
                'content'     => 'Never trust client-side input alone. Laravel Form Requests validate incoming fields automatically, return clear validation error messages to the view, and protect applications against malformed or malicious payloads.',
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'user_id'     => $post['user_id'],
                'category_id' => $post['category_id'],
                'title'       => $post['title'],
                'slug'        => Str::slug($post['title']),
                'content'     => $post['content'],
                'status'      => true,
                'image'       => null,
            ]);
        }

        // 5. Custom Pages
        Page::create([
            'user_id' => $admin->id,
            'name'    => 'About Us',
            'slug'    => 'about-us',
            'content' => 'Alpha Mode Tech Blog is a sample Laravel 11 Content Management System demonstrating database connectivity, session management, role-based authorization, form validation, file uploads, and REST APIs.',
            'navbar'  => true,
            'footer'  => true,
        ]);

        Page::create([
            'user_id' => $admin->id,
            'name'    => 'Contact',
            'slug'    => 'contact',
            'content' => 'Have questions about our PHP & Laravel project? Reach out to Group Alpha Mode at contact@alphamode.dev.',
            'navbar'  => true,
            'footer'  => true,
        ]);

        // 6. Tags
        foreach (['PHP 8', 'Laravel 11', 'MVC', 'Eloquent ORM', 'REST API', 'Tailwind CSS'] as $tagName) {
            Tag::create(['name' => $tagName]);
        }
    }
}