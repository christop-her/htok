<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $clientEmails;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->clientEmails = [];
        echo "Server started\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
        echo "Currently connected clients: " . count($this->clients) . "\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if (isset($data['recieverEmail'])) {
            // Store the email with the connection
            $this->clientEmails[$from->resourceId] = $data['recieverEmail'];
            echo "Email associated with connection {$from->resourceId}: {$data['recieverEmail']}\n";
        }

        $numRecv = count($this->clients);
        echo sprintf(
            'Connection %d sending message "%s" to %d connection%s' . "\n",
            $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if (isset($data['recipientEmail'])) {
                $recipientEmail = $data['recipientEmail'];
                if (isset($this->clientEmails[$client->resourceId]) && $this->clientEmails[$client->resourceId] === $recipientEmail) {
                    echo "Sending message to {$client->resourceId}\n";
                    $client->send($msg);

                     // Send confirmation to the sender
        $confirmationMessage = json_encode([
            'action' => 'message_sent',
            'message' => $msg,
            'to' => $data['recipientEmail']
        ]);
        echo "Message sent confirmation to {$from->resourceId}\n";
        $from->send($confirmationMessage);
                }
            }
        }

       
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it and its email
        $this->clients->detach($conn);
        unset($this->clientEmails[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
        echo "Currently connected clients: " . count($this->clients) . "\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
