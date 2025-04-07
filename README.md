# 🎟️ Ticket Management System API

A modern, API-first Laravel project that enables seamless ticket management — designed in the spirit of a Kanban board but powered by robust, scalable backend architecture.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg?style=flat&logo=laravel)](https://laravel.com)
[![Docker](https://img.shields.io/badge/Built%20With-Laravel%20Sail-blue?style=flat&logo=docker)](https://laravel.com/docs/sail)

## 🌐 Key Highlights

-   ✅ **Versioned APIs** — Built with future-proofing in mind.
-   🎯 **Dynamic Filtering** — Query API endpoints using a flexible, intuitive filter system.
-   🔐 **Policy-Based Authorization** — Robust access control using Laravel Policies.
-   🛡️ **Token Abilities & Permissions** — Fine-grained permission control at the token level.
-   📄 **JSON:API Specification** — Fully adheres to [JSON:API standard](https://jsonapi.org/format/#document-structure).
-   🐳 **Laravel Sail (Docker)** — Get started in minutes with a full Docker setup.
-   🧪 **PestPHP v3+ for Testing** — Elegant and expressive test framework for writing clean, readable test cases.

## 🚀 Quick Start

### Requirements

-   Docker
-   Laravel Sail (included)

### Setup Instructions

```bash
git clone https://github.com/lalithhakari/ticket-api.git
cd ticket-api
cp .env.example .env
sail up -d
sail artisan migrate:fresh --seed
```

This will spin up your Docker containers and prepare the database with sample data.

🧠 Why This Project Stands Out

This project is designed to reflect real-world API architecture using Laravel 12:
• Demonstrates a clean and extensible backend for ticket-based systems.
• Ideal for learning advanced Laravel concepts like token management, authorization, and filtering.
• Great foundation for building scalable task or support ticket systems.
• Easy-to-read, well-structured codebase for developers to build on top of.

🧱 Tech Stack
• Backend: Laravel 12
• API Auth: Laravel Sanctum (Token Abilities)
• Database: MySQL
• Dev Environment: Laravel Sail (Docker)
• Standards: JSON:API, RESTful Routing
• Testing: PestPHP v3+

📣 Contributing

Contributions, issues, and feature requests are welcome! 1. Fork the repository 2. Create your feature branch (git checkout -b feature/new-feature) 3. Commit your changes (git commit -am 'Add new feature') 4. Push to the branch (git push origin feature/new-feature) 5. Create a new Pull Request
