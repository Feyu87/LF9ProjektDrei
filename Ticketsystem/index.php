<?php
require_once('backend.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Doubtful-Joy - Ticket System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 70%;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="center-align">Doubtful-Joy - Ticket System</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="input-field">
            <input type="text" name="id" id="id" autocomplete="on" autocapitalize="none" required>
            <label for="id">ID</label>
        </div>
        <div class="input-field">
            <input type="text" name="name" id="name" autocomplete="on" autocapitalize="words" required>
            <label for="name">Name</label>
        </div>
        <div class="input-field">
            <input type="email" name="email" id="email" autocomplete="on" autocapitalize="none" required>
            <label for="email">Email</label>
        </div>
        <div class="input-field">
            <select name="subject" id="subject">
                <option value="" disabled selected>Wähle ein Thema</option>
                <option value="Support">Support</option>
                <option value="Billing">Billing</option>
                <option value="Technical">Technical</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="input-field">
            <textarea name="message" id="message" class="materialize-textarea" autocomplete="off"
                      autocapitalize="sentences" required></textarea>
            <label for="message">Anliegen</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="submit_ticket">Ticket absenden
            <i class="material-icons right">send</i>
        </button>
        <button class="btn waves-effect waves-light red" type="reset">Felder zurücksetzen</button>
        <button class="btn waves-effect waves-light green" type="submit" name="fetch_tickets">Tickets abrufen</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit_ticket'])) {
            submit_ticket($_POST['id'], $_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);
        }
    }

    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fetch_tickets'])) {
        $tickets = fetch_tickets();

        if (!empty($tickets)) {
            echo "<table class='striped'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Thema</th>
                            <th>Anliegen</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($tickets as $ticket) {
                echo "<tr>
                        <td>" . $ticket["id"] . "</td>
                        <td>" . $ticket["name"] . "</td>
                        <td>" . $ticket["email"] . "</td>
                        <td>" . $ticket["subject"] . "</td>
                        <td>" . $ticket["message"] . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='orange-text'>Keine Tickets gefunden.</p>";
        }
    }
    ?>
</div>
<!-- ... -->
</body>
</html>

</div>
</body>
</html>