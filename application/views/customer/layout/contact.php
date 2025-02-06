<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Icons</title>
    <style>
        .contact-list {
            display: none;
            position: fixed;
            bottom: 10px;
            right: 10px;
            flex-direction: column;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .contact-list.show {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        .contact-list a {
            margin: 5px 0;
        }

        .contact-icon {
            position: fixed;
            bottom: 10px;
            right: 10px;
            cursor: pointer;
            background-color: #8BC34A; /* Warna hijau */
            padding: 10px;
            border-radius: 8px;
        }

        .contact-icon img {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="contact-icon" onclick="toggleContacts()">
        <img src="icon-chat.png" alt="Contact Icon" id="main-icon">
    </div>
    <div class="contact-list" id="contact-list">
        <a href="tel:+123456789"><img src="icon-telepon.png" alt="Phone"></a>
        <a href="https://wa.me/123456789"><img src="icon-whatsapp.png" alt="WhatsApp"></a>
        <a href="https://m.me/username"><img src="icon-messenger.png" alt="Messenger"></a>
        <a href="mailto:email@example.com"><img src="icon-email.png" alt="Email"></a>
        <a href="https://instagram.com/username"><img src="icon-instagram.png" alt="Instagram"></a>
        <a href="https://maps.google.com/?q=location"><img src="icon-lokasi.png" alt="Location"></a>
    </div>

    <script>
        function toggleContacts() {
            var contactList = document.getElementById('contact-list');
            if (contactList.classList.contains('show')) {
                contactList.classList.remove('show');
            } else {
                contactList.classList.add('show');
            }
        }
    </script>
</body>
</html>
