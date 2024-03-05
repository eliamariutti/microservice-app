## Laravel API exercise
This application is designed to manage specific POST and GET requests, handle tasks asynchronously, and follow a Test-Driven Development (TDD) approach with Pest.

## Installation
1. Clone the repository
2. Run "./setup.sh" to set up the environment and run the application in a Docker container
3. Run "./vendor/bin/sail artisan queue:work" to start the queue worker
4. The application will be available at http://localhost:80

## Usage
The application is designed to handle the following requests:
- POST /api/v1/jobs
- GET /api/v1/jobs/{uuid}

## Testing
Run "./vendor/bin/pest" to run the tests (Feature, Unit and Stress tests)

## Api Specification
The OpenAPI documentation is available at http://localhost:80/api/documentation