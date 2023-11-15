# Airline Ticket Booking Project

This project is a web-based application for booking airline tickets. It utilizes HTML, CSS, and JavaScript for the front end and PHP for the back end.

## Features

- User registration and authentication
- Browse available flights
- Search for flights based on various criteria (destination, date, etc.)
- Select and book flights
- View and manage booked flights
- Payment processing (a simple example, not for actual use)
- Admin panel for managing flights and user bookings

## Technologies Used

- **Frontend:**

  - HTML
  - CSS
  - JavaScript

- **Backend:**
  - PHP

## Getting Started

### Prerequisites

- Web server (e.g., Apache, Nginx)
- PHP installed
- MySQL database

### Database Setup

1. **Create a New MySQL Database:**
   -Make a database on mysql named test
   -create the following tables
   CREATE TABLE airflight_details (
   booking_reference VARCHAR(255) NOT NULL,
   flight_number VARCHAR(255) NOT NULL,
   date_time DATETIME NOT NULL,
   gate VARCHAR(255) NOT NULL,
   price DECIMAL(10,2) NOT NULL,
   placeName VARCHAR(255) NOT NULL,
   PRIMARY KEY (booking_reference)
   );

CREATE TABLE booking (
id INT NOT NULL AUTO_INCREMENT,
placeName VARCHAR(255),
seatNumber VARCHAR(255),
arrivalDate DATE,
departureDate DATE,
PRIMARY KEY (id)
);

CREATE TABLE message_table (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
number INT NOT NULL,
subject VARCHAR(255) NOT NULL,
message TEXT NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE passengers (
id INT NOT NULL AUTO_INCREMENT,
passenger_name VARCHAR(255),
booking_reference VARCHAR(255),
flight_number VARCHAR(255),
departure VARCHAR(255),
arrival VARCHAR(255),
date_time DATETIME,
seat VARCHAR(10),
gate VARCHAR(10),
price DECIMAL(10,2),
PRIMARY KEY (id)
);

CREATE TABLE users (
id INT NOT NULL AUTO_INCREMENT,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
PRIMARY KEY (id)
);

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/airline-ticket-booking.git
   ```
