# Tangier Inspire Blog
---

## Table of Contents

1. [Project Overview](#project-overview)  
2. [Problem Statement](#problem-statement)  
3. [Proposed MVP Solution](#proposed-mvp-solution)  
4. [Success Metrics](#success-metrics)  
5. [Features & Use Cases](#features--use-cases)  
6. [Technical Stack](#technical-stack)  
7. [Database Schema](#database-schema)  
8. [Laravel Implementation](#laravel-implementation)  
   - [Models](#models)  
   - [Migrations](#migrations)  
   - [Factories](#factories)  
   - [Seeders](#seeders)  
9. [Commands](#commands)  
10. [License](#license)  

---

## Project Overview

Tangier Inspire Blog is a web platform where an **admin publishes articles, events, and artist profiles** about Tangier’s cultural and digital initiatives. The goal is to provide visitors with a curated, inspiring view of the city’s creative projects.  

---

## Problem Statement

Current platforms in Tangier are outdated or lack curated, reliable content. We aim to create a **simple admin-managed blog** to showcase Tangier’s creativity efficiently and beautifully.  

---

## Proposed MVP Solution

- **Home page:** Highlights latest articles, events, and artist profiles  
- **Admin-only publishing:** Only the admin can post and manage content  
- **Responsive Web Experience:** Desktop, tablet, and mobile (Tailwind CSS + Laravel Blade)  

---

## Success Metrics

- ≥ 70% of visitors view at least one article, event, or artist profile during their session.  

---

## Features & Use Cases

### Prioritized Features (MoSCoW)

| Feature | Description | Priority |
|---------|-------------|---------|
| Homepage Feed | Latest articles, events, artist highlights | Must |
| Publish Article | Title, body, images, category | Must |
| Responsive Design | Mobile-first, fast loading | Must |

---

### Use Cases

| ID | Actor | Action | Benefit | Priority |
|----|-------|--------|---------|---------|
| UC1 | Visitor | Explore recent initiatives | Discover Tangier’s creative scene | Must |
| UC2 | Admin | Publish articles, events, and artists | Share curated content | Must |

---

## Technical Stack

- **Frontend:** Tailwind CSS + Laravel Blade  
- **Backend:** Laravel  
- **Database:** MySQL / MariaDB  
- **Testing:** Laravel Tinker, Factories & Seeders  

---

## Database Schema

### Tables:

1. **admins**
   - id, name, email, password, timestamps  
2. **posts**
   - id, admin_id (FK), title, slug, content, image, published_at, timestamps  
3. **events**
   - id, title, description, city, date, image, timestamps  
4. **artists**
   - id, name, city, field, bio, photo, timestamps  

### Relationships

- Admin → hasMany → Posts  
- Post → belongsTo → Admin  

---

## Laravel Implementation

### Models

- `Admin.php` → manages all posts  
- `Post.php` → articles published by admin  
- `Artist.php` → featured Tangier artists  
- `Event.php` → Tangier events  

---

### Migrations

Create tables using:
```bash
php artisan make:model Admin -m -f
php artisan make:model Post -m -f
php artisan make:model Artist -m -f
php artisan make:model Event -m -f
````

Run migrations:

```bash
php artisan migrate
```

---

### Factories

* `AdminFactory.php` → create admin
* `PostFactory.php` → create posts
* `ArtistFactory.php` → create artists
* `EventFactory.php` → create events

---

### Seeders

`DatabaseSeeder.php` seeds initial data:

```php
$admin = Admin::factory()->create();
Post::factory(5)->create(['admin_id' => $admin->id]);
Event::factory(5)->create();
Artist::factory(5)->create();
```

---

## Commands

### Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

### Tinker (test database)

```bash
php artisan tinker
Admin::all();
Post::all();
Event::all();
Artist::all();
```

### Artisan Helpers

```bash
php artisan migrate:status
php artisan route:list
php artisan serve
```

---

### Example Tinker Queries

```php
$admin = Admin::first();
$admin->posts; // all posts by admin

Post::whereNotNull('published_at')->get(); // published posts
Event::whereDate('date', '>=', now()->toDateString())->get(); // upcoming events
Artist::all(); // list artists
```

---

