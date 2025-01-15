<?php
session_start();

if (isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit;
}

require __DIR__ . "/../src/google-login-api/apiClient.php";
require __DIR__ . "/../src/google-login-api/contrib/apiOauth2Service.php";
$googleClientConfig = json_decode(file_get_contents(__DIR__ . '/../google_client.json'), true);

if (isset($googleClientConfig['web'])) {
    $clientConfig = $googleClientConfig['web'];
    $clientid = $clientConfig['client_id'];
    $clientsecret = $clientConfig['client_secret'];
    $redirecturi = $clientConfig['redirect_uris'][0];

    $client = new apiClient();
    $client->setApplicationName('Chat GPT');
    $client->setClientId($clientid);
    $client->setClientSecret($clientsecret);
    $client->setRedirectUri($redirecturi);

    $apiKey = 'AIzaSyCVeQmIq-WUGc9YVuIxMKD3rgVzFRE1dnM';
    $client->setDeveloperKey($apiKey);

    $scopes = [
        'https://www.googleapis.com/auth/calendar',
        'profile',
        'email'
    ];
    $client->setScopes($scopes);

    // Đặt các thuộc tính xác thực
    $client->setAccessType('online');
    $client->setApprovalPrompt('auto');

    // Khởi tạo dịch vụ OAuth2
    $oauth2 = new apiOauth2Service($client);
}

// Hàm lấy URL đăng nhập Google
function loginURL()
{
    global $client;
    return $client->createAuthUrl();
}

// Hàm xác thực người dùng
function getAuthenticate()
{
    global $client;
    return $client->authenticate();
}

// Lấy token truy cập
function getAccessToken()
{
    global $client;
    return $client->getAccessToken();
}

// Thiết lập token truy cập
function setAccessToken($token)
{
    global $client;
    return $client->setAccessToken($token);
}

// Hủy bỏ token
function revokeToken()
{
    global $client;
    return $client->revokeToken();
}

// Lấy thông tin người dùng
function getUserInfo()
{
    global $oauth2;
    return $oauth2->userinfo->get();
}

if (isset($_GET['code'])) {
    getAuthenticate($_GET['code']);
    $token = getAccessToken();

    if (isset($token['access_token'])) {
        $this->session->set_userdata('google_token', $token);
    }
    $gpInfo = getUserInfo();

    $settings = require __DIR__ . '/../settings.php';
    $dbConfig = $settings['db'];

    try {
        $pdo = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $gpInfo['email']);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['is_admin'] = ($user['role_id'] == 1);
    } else {
        $query = "INSERT INTO users (email, name) VALUES (:email, :name)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $gpInfo['email']);
        $stmt->bindParam(':name', $gpInfo['name']);

        if ($stmt->execute()) {
            $userId = $pdo->lastInsertId();

            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $gpInfo['email'];
            $_SESSION['name'] = $gpInfo['name'];
            $_SESSION['user_id'] = $userId; 
            $_SESSION['role_id'] = 4; 
            $_SESSION['is_admin'] = false;
        } else {
            echo "There was an error creating the user.";
        }
    }

    if ($_SESSION['is_admin']) {
        header("Location: admin.php");
        exit;
    }

    header("Location: index.php");
    exit;
}

$login_url = loginURL();

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Chat GPT</title>
</head>
<style>
    .login-with-google-btn {
        transition: background-color .3s, box-shadow .3s;
        padding: 12px 16px 12px 42px;
        border: none;
        border-radius: 3px;
        box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);

        color: #757575;
        font-size: 14px;
        font-weight: 500;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;

        background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
        background-color: white;
        background-repeat: no-repeat;
        background-position: 12px 11px;

        &:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
        }

        &:active {
            background-color: #eeeeee;
        }

        &:focus {
            outline: none;
            box-shadow:
                0 -1px 0 rgba(0, 0, 0, .04),
                0 2px 4px rgba(0, 0, 0, .25),
                0 0 0 3px #c8dafc;
        }

        &:disabled {
            filter: grayscale(100%);
            background-color: #ebebeb;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);
            cursor: not-allowed;
        }
    }

    body {
        text-align: center;
        padding-top: 2rem;
    }
</style>

<body>
    <h1>Đăng nhập</h1>
    <form method="POST" action="<?php echo $login_url ?>">
        <button type="submit" class="login-with-google-btn">
            Đăng nhập với Google
        </button>
    </form>
</body>
<script>

</script>

</html>