<!-- resources/views/start_new_conversation.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start New Conversation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="max-w-lg mx-auto my-8 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Start New Conversation</h1>
    <form id="startConversationForm">
        <textarea name="message" rows="4" cols="50" class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Message"></textarea>
        <input type="email" name="recipient_email" class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Recipient Email">
        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Start Conversation</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    document.getElementById('startConversationForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        axios.post('/start-conversation', formData)
            .then(function (response) {
                console.log(response.data);
                alert(response.data.status);
            })
            .catch(function (error) {
                console.error(error);
            });
    });
</script>
</body>
</html>
