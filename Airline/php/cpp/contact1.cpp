#include <mysql_driver.h>
#include <mysql_connection.h>
#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/prepared_statement.h>

#include <iostream>
#include <string>

using namespace std;

struct Node {
    string name;
    string email;
    int number;
    string subject;
    string message;
    Node* next;

    Node(string name, string email, int number, string subject, string message)
        : name(name), email(email), number(number), subject(subject), message(message), next(nullptr) {}
};

class LinkedList {
public:
    Node* head;

    LinkedList() : head(nullptr) {}

    void insert(string name, string email, int number, string subject, string message) {
        Node* newNode = new Node(name, email, number, subject, message);
        newNode->next = head;
        head = newNode;
    }
};

int main() {
    try {
        sql::mysql::MySQL_Driver* driver;
        sql::Connection* con;

        driver = sql::mysql::get_mysql_driver_instance();
        con = driver->connect("tcp://127.0.0.1:3306", "root", "sarthak@1226");

        con->setSchema("test");

        LinkedList linkedList;

        string name = "John Doe";
        string email = "john@example.com";
        int number = 12345;
        string subject = "Test Subject";
        string message = "This is a test message.";

        linkedList.insert(name, email, number, subject, message);

        Node* currentNode = linkedList.head;
        while (currentNode != nullptr) {
            string name = currentNode->name;
            string email = currentNode->email;
            int number = currentNode->number;
            string subject = currentNode->subject;
            string message = currentNode->message;

            sql::PreparedStatement* pstmt;
            pstmt = con->prepareStatement("INSERT INTO message_table (name, email, number, subject, message) VALUES (?, ?, ?, ?, ?)");
            pstmt->setString(1, name);
            pstmt->setString(2, email);
            pstmt->setInt(3, number);
            pstmt->setString(4, subject);
            pstmt->setString(5, message);
            pstmt->executeUpdate();

            delete pstmt;

            currentNode = currentNode->next;
        }

        delete con;

        cout << "Data successfully stored in the database." << endl;
    } catch (sql::SQLException& e) {
        cout << "Error: " << e.what() << endl;
    }

    return 0;
}
