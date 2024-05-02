<!-- resources/views/send_message.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
</head>
<body>
<form id="sendMessageForm">
    <textarea name="message" rows="4" cols="50"></textarea><br><br>
    <input type="hidden" name="recipients[]" value="1"> <!-- Example: You may loop through users to add recipients -->
    <input type="hidden" name="recipients[]" value="2">
    <button type="submit">Send Message</button>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    document.getElementById('sendMessageForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        axios.post('/send-message', formData)
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
