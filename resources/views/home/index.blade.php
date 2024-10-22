<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Supermarket</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            display: flex;
            padding: 15px;
            background-color: #0554F2;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .button {
            background-color: white;
            color: #0554F2;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block; /* Makes the button a block element */
            margin: 0 auto; /* Centers the button */
        }
        .button:hover {
            background-color: #e7e7e7;
        }
        .welcome {
            text-align: center;
            margin: 20px 0;
        }
        .content {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            text-align: center;
            width: 200px;
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        footer {
            background-color: #0554F2;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-link {
            margin-top: 0px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('home') }}"><img src="logo.jpeg" alt="Logo" width="100"></a>
        <a href="{{ route('home') }}"><img src="jti.png" alt="Logo" width="50"></a>
        <div class="login-container">
            <a href="{{ route('login') }}">
                <button class="button">Login</button>
            </a>
            <a class="login-link" href="{{ route('login') }}">Login Administrator</a>
        </div>
    </div>
    <div class="welcome">
        <h1>Selamat Datang di Supermarket JTI!</h1>
        <p>Temukan produk terbaik hanya untuk Anda, Login terlebih dahulu untuk melihat produk yang tersedia!</p>
    </div>
    <div class="content">
        @foreach($products as $product)
        <div class="card">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
            <h2>{{ $product['name'] }}</h2>
            <p>{{ $product['description'] }}</p>
        </div>
        @endforeach
    </div>
    <footer>
        <p>&copy; 2024 Supermarket. All rights reserved.</p>
    </footer>
</body>
</html>