#include <iostream>
#include <fstream>
#include <string>
#include <queue>
#include <mysql_driver.h>
#include <mysql_connection.h>

using namespace std;


struct Passenger {
    string passengerName;
    string bookingReference;
    string flightNumber;
    string departure;
    string arrival;
    string dateTime;
    string seat;
    string gate;
    string price;
};


class PassengerQueue {
private:
    queue<Passenger> data;

public:

    void enqueue(const Passenger& passenger) {
        data.push(passenger);
    }

    void dequeue() {
        if (!data.empty()) {
            data.pop();
        }
    }

    void saveToFile() {
        ofstream outFile("passenger_queue.txt");
        while (!data.empty()) {
            Passenger passenger = data.front();
            data.pop();

            outFile << "Passenger Name: " << passenger.passengerName << "\n";
            outFile << "Booking Reference: " << passenger.bookingReference << "\n";
            outFile << "Flight Number: " << passenger.flightNumber << "\n";
            outFile << "Departure: " << passenger.departure << "\n";
            outFile << "Arrival: " << passenger.arrival << "\n";
            outFile << "Date Time: " << passenger.dateTime << "\n";
            outFile << "Seat: " << passenger.seat << "\n";
            outFile << "Gate: " << passenger.gate << "\n";
            outFile << "Price: " << passenger.price << "\n\n";
        }
        outFile.close();
    }
};

int main() {
    sql::mysql::MySQL_Driver *driver;
    sql::Connection *con;

    driver = sql::mysql::get_mysql_driver_instance();
    con = driver->connect("tcp://127.0.0.1:3306", "root", "sarthak@1226");


    con->setSchema("test");

    string user = "John Doe";
    string sql = "SELECT * FROM passengers WHERE passenger_name = ?";
    sql::PreparedStatement *stmt = con->prepareStatement(sql);
    stmt->setString(1, user);
    sql::ResultSet *result = stmt->executeQuery();

    PassengerQueue passengerQueue;

    while (result->next()) {
        Passenger passenger;
        passenger.passengerName = result->getString("passenger_name");
        passenger.bookingReference = result->getString("booking_reference");
        passenger.flightNumber = result->getString("flight_number");
        passenger.departure = result->getString("departure");
        passenger.arrival = result->getString("arrival");
        passenger.dateTime = result->getString("date_time");
        passenger.seat = result->getString("seat");
        passenger.gate = result->getString("gate");
        passenger.price = result->getString("price");

        passengerQueue.enqueue(passenger);
    }

    delete result;
    delete stmt;
    delete con;

    if (!passengerQueue.empty()) {
        passengerQueue.saveToFile();
        cout << "Passenger data saved to passenger_queue.txt" << endl;
    } else {
        cout << "Passenger not found" << endl;
    }

    return 0;
}
