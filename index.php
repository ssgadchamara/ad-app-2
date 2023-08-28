<?php
$ldap_server = "ldap://intranet.slt.com.lk";
$ldap_port = 389;
$ldap_domain = "intranet.slt.com.lk"; // Change this to your AD domain

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
        $ldap_conn = ldap_connect($ldap_server, $ldap_port);
        if ($ldap_conn) {
            ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

            $ldap_bind = @ldap_bind($ldap_conn, "$username@$ldap_domain", $password);

            if ($ldap_bind) {
                $auth_message = "Authentication successful!";
                $auth_message_class = "success-message";
            } else {
                $auth_message = "Authentication failed!";
                $auth_message_class = "error-message";
            }

            ldap_close($ldap_conn);
        } else {
            $auth_message = "Could not connect to LDAP server.";
            $auth_message_class = "error-message";
        }
    } else {
        $auth_message = "Please enter both username and password.";
        $auth_message_class = "error-message";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LDAP Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 50px;
        }
        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box; /* Add this line for proper sizing */
        }
        input[type="submit"] {
            background-color: #ff9800;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #f57c00;
        }
        .auth-message {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            border-radius: 3px;
            font-weight: bold;
        }
        .success-message {
            background-color: #4caf50;
            color: white;
        }
        .error-message {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username">
        <label>Password:</label>
        <input type="password" name="password">
        <input type="submit" value="Login">
    </form>
    <?php if (isset($auth_message)) : ?>
        <p class="auth-message <?php echo $auth_message_class; ?>"><?php echo $auth_message; ?></p>
    <?php endif; ?>
</body>
</html>
