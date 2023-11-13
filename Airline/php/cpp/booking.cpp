#include <mysql_driver.h>
#include <mysql_connection.h>
#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/prepared_statement.h>

#include <iostream>
#include <string>

using namespace std;

int main() {
    try {
        sql::mysql::MySQL_Driver *driver;
        sql::Connection *con;

        driver = sql::mysql::get_mysql_driver_instance();
        con = driver->connect("tcp://127.0.0.1:3306", "root", "sarthak@1226");

        con->setSchema("test");

        string placeName, seatNumber, arrivalDate, leavingDate;

        cout << "Enter Place Name: ";
        getline(cin, placeName);

        cout << "Enter Seat Number: ";
        getline(cin, seatNumber);

        cout << "Enter Arrival Date (YYYY-MM-DD): ";
        getline(cin, arrivalDate);

        cout << "Enter Leaving Date (YYYY-MM-DD): ";
        getline(cin, leavingDate);

        sql::PreparedStatement *pstmt;
        pstmt = con->prepareStatement("INSERT INTO booking (place_name, seat_number, arrival_date, leaving_date) VALUES (?, ?, ?, ?)");
        pstmt->setString(1, placeName);
        pstmt->setString(2, seatNumber);
        pstmt->setString(3, arrivalDate);
        pstmt->setString(4, leavingDate);
        pstmt->executeUpdate();

        delete pstmt;
        delete con;

        cout << "Data successfully stored in the database." << endl;
    } catch (sql::SQLException &e) {
        cout << "Error: " << e.what() << endl;
    }

    return 0;
}
