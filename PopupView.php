<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup Example</title>
</head>
<body>
    <h1>Your PHP Content</h1>
    
    <!-- JavaScript to trigger the popup -->
    <script>
        function openPopup() {
            // Show the modal or popup
            document.getElementById('popup').style.display = 'block';
        }
    </script>

    <!-- Button to trigger the popup -->
    <button onclick="openPopup()">Open Popup</button>

    <!-- Your popup content -->
    <div id="popup" 
        style="
            display: none; 
            width: 80vw;
            height: 80vh;
            position: fixed; 
            top: 50%; left: 50%; 
            transform: translate(-50%, -50%); 
            background: white; 
            padding: 20px;
            white-space:nowrap;
            overflow:scroll;
            border: 1px solid #ccc; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2>Popup Content</h2>
        <div>
        <p>
            This is your popup content.
            This is your popup content.
            This is your popup content.
            This is your popup content.
            This is your popup content.
        </p>
        <p>This is your popup content.</p>
        <p>This is your popup content.</p>

        <label for="test">
            <input 
                type="submit" 
                value="ボタン" 
                id="test" 
                onclick="window.location.href = 'https://www.google.com/';
            ">
        </label>
        </div>
        <button onclick="document.getElementById('popup').style.display = 'none'">Close Popup</button>
    </div>
</body>
</html>
