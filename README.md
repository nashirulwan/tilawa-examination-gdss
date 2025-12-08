# GDSS for Quran Recitation Competition (MTQ)

## Project Overview

This web-based Group Decision Support System (GDSS) is designed to streamline and objectify the evaluation process involved in Quran Recitation Competitions (Musabaqah Tilawatil Quran). By integrating the **SMART** (Simple Multi-Attribute Rating Technique) method for individual assessment and the **Borda Count** method for group consensus, the system ensures fair, transparent, and mathematically rigorous rankings.

## Core Features & Processes

The system facilitates the entire competition lifecycle through the following key processes:

1.  **Administrative Management (Committee)**
    *   **User Management**: create and manage accounts for committee members and appraisers (judges).
    *   **Participant Management**: Register participants, assign them to periods/years, and manage their status (Active/Inactive) and departments.
    *   **Criteria Configuration**: Define and weight assessment criteria (e.g., Fashah, Tajweed, Voice, Song) to standards.

2.  **Assessment Phase (Appraisers)**
    *   Appraisers log in to a dedicated interface to evaluate participants.
    *   Scoring is performed against the predefined criteria.
    *   The system automatically calculates the **SMART score** (Utility * Weight) for each partial assessment.

3.  **Decision Support & Reporting**
    *   **SMART Calculation**: Converts raw scores into normalized utility values and weighted scores for individual rankings.
    *   **Borda Consensus**: Aggregates individual rankings from all appraisers into a single group consensus using the Borda Count method (Rank 1 = N points, Rank N = 1 point).
    *   **Analytical Dashboards**: Visualizes participant demographics and provides real-time system status.
    *   **Detailed Reports**: Offers transparent breakdowns of calculations, showing raw values, utility conversions, and final Borda points.

## System Requirements

*   Docker & Docker Compose
*   Node.js & NPM (for frontend asset compilation)

## Installation Guide

Follow these steps to deploy the application with a fully seeded database.

### 1. Application Setup

Clone the repository and navigate to the project directory.

```bash
# Copy the environment configuration
cp .env.example .env
```

Ensure your `.env` file is configured for the Docker environment (default settings usually suffice for local development using the provided `docker-compose.yml`).

### 2. Infrastructure Initialization

Start the containerized services (App, Web Server, Database).

```bash
docker-compose up -d --build
```

### 3. Dependency Installation

Install backend (PHP/Composer) and frontend (Node/NPM) dependencies.

```bash
# Install PHP dependencies
docker-compose exec app composer install

# Install Node dependencies
npm install
```

### 4. Database Configuration

Generate the application key and initialize the database. This step includes running migrations and seeding the database with required reference data and sample users.

```bash
# Generate App Key
docker-compose exec app php artisan key:generate

# Migrate and Seed Database
# This creates all tables and populates them with default admin/appraiser accounts and sample participants.
docker-compose exec app php artisan migrate:fresh --seed
```

### 5. Frontend Compilation

Start the Vite development server to compile and serve frontend assets.

```bash
npm run dev
```

### 6. Accessing the System

The application is now accessible at: **http://localhost:8000**

**Default Credentials:**

*   **Committee (Admin)**
    *   Email: `admin@example.com`
    *   Password: `password`
*   **Appraiser (Judge)**
    *   Email: `appraiser@example.com`
    *   Password: `password`
