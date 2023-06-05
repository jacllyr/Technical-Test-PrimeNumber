# Technical test

## A Prime Number form

This project is a web application utilizing load balancers with NGINX and a docker-compose.yaml file. It consists of multiple nodes to ensure high availability. The web application features a prime number form that operates through a JSON REST API. Users can input the prime number 'X', and the system performs input and request validation. It then returns a list of all prime numbers that are less than or equal to 'X'.

## Presentation Tier

The presentation structure consists of the front-end, which includes a load balancer directory, a Dockerfile, and an NGINX configuration file. The source directory contains HTML, PHP, and CSS asset files. The form structure is located in `form.php`, which handles the $response request from the back-end, where the business logic is implemented.

## Business logic Tier

The business directory manages the form logic response, specifically the `logic.php` file, which receives the response from the presentation tier. In this file, the validation process for prime numbers takes place.

## Prerequisites

You must have Docker installed on your system to proceed with the installation and testing. *It is recommended that you clone this project within a WSL or Linux VM with Docker installed for the following guide.*

Install Docker-compose

`https://www.docker.com/products/docker-desktop/`

Start up Docker daemon services.

`sudo systemctl start docker`

## Installation

clone the repo in a WSL or linux environment using distro of your choice.

`git clone https://github.com/jacllyr/Technical-Test-PrimeNumber.git`

Or unzip the package `Technical-Test-PrimeNumber.zip`

cd inside the root folder 

`cd Technical-Test-PrimeNumber`

Update the distro packages

`sudo apt update`

Start the docker container

`sudo docker-compose up`

Open the webite form application 

`http://localhost:80`

To stop services

`docker-compose down` or `CTRL C`

## Automated testing

To perform automated testing, you need to navigate to the root project directory and execute the provided command using sudo bash.

cd to root of project for execution.

`cd Technical-Test-PrimeNumber`

### Prime number input

Automated testing - `sudo bash test_prime.sh`

### Verify docker containers are running

`docker container ls`