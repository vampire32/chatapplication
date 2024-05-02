<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<x-start_new_conversation/>
<h1 class="text-3xl font-bold text-center my-4">Messages</h1>
<div id="messages" class="max-w-lg mx-auto"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script type="application/javascript">
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

        // Group messages by user
        var groupedMessages = {};
        messages.forEach(function (message) {
            var userId = message.user.id;
            if (!groupedMessages[userId]) {
                groupedMessages[userId] = [];
            }
            groupedMessages[userId].push(message);
        });

        // Loop through grouped messages and create list for each user
        Object.keys(groupedMessages).forEach(function (userId) {
            var userMessages = groupedMessages[userId];

            var userMessageList = document.createElement('ul');
            var userName = userMessages[0].user.name; // User's name from the first message
            var userTitle = document.createElement('h3');
            userTitle.textContent = userName;
            userTitle.classList.add('text-xl', 'font-semibold', 'mb-2');
            userMessageList.appendChild(userTitle);

            // Loop through user's messages and append them to the list
            userMessages.forEach(function (message) {
                var messageItem = document.createElement('li');
                messageItem.textContent = message.message;
                messageItem.classList.add('py-1');
                userMessageList.appendChild(messageItem);
            });

            // Create reply box for the user
            var replyBox = document.createElement('textarea');
            replyBox.placeholder = 'Reply to ' + userName;
            replyBox.classList.add('border', 'border-gray-300', 'rounded-lg', 'p-2', 'mt-2', 'w-full', 'resize-none');

            // Create button to send reply
            var replyButton = document.createElement('button');
            replyButton.textContent = 'Reply';
            replyButton.classList.add('bg-blue-500', 'text-white', 'font-semibold', 'px-4', 'py-2', 'rounded-lg', 'mt-2', 'hover:bg-blue-600', 'focus:outline-none');
            replyButton.addEventListener('click', function () {
                sendReply(userId, replyBox.value);
            });

            // Append reply box and button to the user's message list
            userMessageList.appendChild(replyBox);
            userMessageList.appendChild(replyButton);

            // Append user's message list to the messages container
            document.getElementById('messages').appendChild(userMessageList);
        });
    }

    // Function to send reply
    function sendReply(recipientId, replyMessage) {
        axios.post('/send-message', {
            recipients: [recipientId],
            message: replyMessage
        })
            .then(function (response) {
                console.log(response.data);
                fetchMessages();

                // Refresh messages after sending reply
            })
            .catch(function (error) {
                console.error('Error sending reply: ', error);
            });
        location.reload();
    }

    // Fetch messages when the page loads
    document.addEventListener('DOMContentLoaded', function () {
        fetchMessages();
    });
</script>
</body>
</html>
