// resources/js/app.js

// Function to fetch messages
function fetchMessages() {
    axios.get('/get-messages')
        .then(function (response) {
            displayMessages(response.data.messages);
        })
        .catch(function (error) {
            console.error('Error fetching messages: ', error);
        });
}

// Function to display messages
function displayMessages(messages) {
    // Clear existing messages from UI
    document.getElementById('messages').innerHTML = '';

    // Loop through messages and append them to UI
    messages.forEach(function (message) {
        var messageItem = document.createElement('li');
        messageItem.textContent = message.message;
        document.getElementById('messages').appendChild(messageItem);
    });
}

// Fetch messages when the page loads
document.addEventListener('DOMContentLoaded', function () {
    fetchMessages();
});
