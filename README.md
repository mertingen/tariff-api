# Tariff API

## Introduction

Tariff API is a Symfony-based application for comparing energy tariffs based on consumption.

## Prerequisites
- Docker
- Docker Compose

## Setup

To run this application locally, make sure you have Docker and Docker Compose installed.

### Setup Script

Use the setup script to build and start the application:

```bash
./setup.sh
```

This script checks for Docker and Docker Compose, builds the Docker images, and starts the containers in detached mode.

Running Tests
To run the PHPUnit tests:

``docker-compose exec php vendor/bin/phpunit``

Environment Variables
Ensure you have a .env file with the following variables set:

``REDIS_HOST=redis
REDIS_PORT=6379``

## Usage

### API Endpoint

#### Compare Tariffs

- **URL:** `/tariffs`
- **Method:** GET
- **Query Parameters:**
    - `consumption` (required): Integer value representing the energy consumption.

#### Example Request

```http
GET /tariffs?consumption=2000

{
  "status": true,
  "message": "",
  "data": [
    {
      "name": "Product A",
      "annualCost": 505
    },
    {
      "name": "Product B",
      "annualCost": 800
    }
  ]
}
```

## Running Tests

To run the PHPUnit tests, execute the following command in your terminal:

```bash
docker-compose exec php vendor/bin/phpunit
```

This command runs all the PHPUnit tests located in the tests/ directory of your Symfony application.

Make sure Docker and Docker Compose are installed and running before executing the command.