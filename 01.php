<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Espresso Junction</title>
    </head>
    <body>
        <h1>Welcome to Espresso Junction</h1>
        <h3>Order Entry</h3>
        
        <?php
        session_start();

        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            session_unset();
        }

        $message = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['page1'])) {
            $_SESSION['qil'] = (int) $_POST['qil'];
            $_SESSION['qia'] = (int) $_POST['qia'];
            $_SESSION['qhl'] = (int) $_POST['qhl'];
            $_SESSION['qha'] = (int) $_POST['qha'];

            if (!isset($_POST['membership']) && !isset($_POST['weather'])) {
                $message = "<br><span style='color:red;'>Please choose membership and weather.</span>";
            } else if (isset($_POST['membership']) && !isset($_POST['weather'])) {
                $_SESSION['membership'] = $_POST['membership'];
                $message = "<br><span style='color:red;'>Please choose weather.</span>";
            } else if (!isset($_POST['membership']) && isset($_POST['weather'])) {
                $message = "<br><span style='color:red;'>Please choose membership.</span>";
                $_SESSION['weather'] = $_POST['weather'];
            } else {
                $_SESSION['weather'] = $_POST['weather'];
                $_SESSION['membership'] = $_POST['membership'];

                $_SESSION['min_quantity'] = 10;
                $_SESSION['qty_disc_rate'] = 0.1;

                $_SESSION['total_quantity'] = $_SESSION['qil'] + $_SESSION['qia'] + $_SESSION['qhl'] + $_SESSION['qha'];

                if ($_SESSION['total_quantity'] == 0) {
                    $message = "<br><span style='color:red;'>Please enter a quantity before proceeding to the next page.</span>";
                } else {
                    if ($_SESSION['membership'] == "yes" && $_SESSION['weather'] == "Sunny") {
                        $_SESSION['pil'] = 9;
                        $_SESSION['pia'] = 9;
                        $_SESSION['phl'] = 9;
                        $_SESSION['pha'] = 9;
                    } else if ($_SESSION['membership'] == "yes" && $_SESSION['weather'] == "Rainy") {
                        $_SESSION['pil'] = 10;
                        $_SESSION['pia'] = 10;
                        $_SESSION['phl'] = 8.9;
                        $_SESSION['pha'] = 8.9;
                    } else {
                        $_SESSION['pil'] = 10;
                        $_SESSION['pia'] = 10;
                        $_SESSION['phl'] = 9;
                        $_SESSION['pha'] = 9;
                    }

                    $_SESSION['til'] = $_SESSION['qil'] * $_SESSION['pil'];
                    $_SESSION['tia'] = $_SESSION['qia'] * $_SESSION['pia'];
                    $_SESSION['thl'] = $_SESSION['qhl'] * $_SESSION['phl'];
                    $_SESSION['tha'] = $_SESSION['qha'] * $_SESSION['pha'];

                    $_SESSION['total1'] = $_SESSION['til'] + $_SESSION['tia'] + $_SESSION['thl'] + $_SESSION['tha'];

                    if ($_SESSION['total_quantity'] >= $_SESSION['min_quantity']) {
                        $_SESSION['qty_disc'] = $_SESSION['total1'] * $_SESSION['qty_disc_rate'];
                    } else {
                        $_SESSION['qty_disc'] = 0;
                    }

                    $_SESSION['total2'] = $_SESSION['total1'] - $_SESSION['qty_disc'];

                    header("Location: 02.php", true, 307);
                    exit();
                }
            }
        }
        ?>
        
        <form method="POST">
            Are you a registered member?
            <br>
            <input
                type="radio"
                name="membership"
                value="yes"
                <?php if (isset($_SESSION['membership']) && $_SESSION['membership'] == "yes") { echo "checked"; } ?>
            > Yes
            <input
                type="radio"
                name="membership"
                value="no"
                <?php if (isset($_SESSION['membership']) && $_SESSION['membership'] == "no") { echo "checked"; } ?>
            > No

            <br><br>

            Current weather is:
            <br>
            <input
                type="radio"
                name="weather"
                value="Sunny"
                <?php if (isset($_SESSION['weather']) && $_SESSION['weather'] == "Sunny") { echo "checked"; } ?>
            > Sunny
            <input
                type="radio"
                name="weather"
                value="Rainy"
                <?php if (isset($_SESSION['weather']) && $_SESSION['weather'] == "Rainy") { echo "checked"; } ?>
            > Rainy
            <input
                type="radio"
                name="weather"
                value="Cloudy"
                <?php if (isset($_SESSION['weather']) && $_SESSION['weather'] == "Cloudy") { echo "checked"; } ?>
            > Cloudy

            <br><br>

            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>Drinks</th>
                    <th>Sunny</th>
                    <th>Rainy</th>
                    <th>Cloudy</th>
                    <th>Quantity</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Iced Latte</td>
                    <td>RM9.00</td>
                    <td>RM10.00</td>
                    <td>RM10.00</td>
                    <td>
                        <input
                            type="number"
                            name="qil"
                            value="<?php echo isset($_SESSION['qil']) ? $_SESSION['qil'] : 0; ?>"
                            min="0"
                        >
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Iced Americano</td>
                    <td>RM9.00</td>
                    <td>RM10.00</td>
                    <td>RM10.00</td>
                    <td>
                        <input
                            type="number"
                            name="qia"
                            value="<?php echo isset($_SESSION['qia']) ? $_SESSION['qia'] : 0; ?>"
                            min="0"
                        >
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Hot Latte</td>
                    <td>RM9.00</td>
                    <td>RM8.90</td>
                    <td>RM9.00</td>
                    <td>
                        <input
                            type="number"
                            name="qhl"
                            value="<?php echo isset($_SESSION['qhl']) ? $_SESSION['qhl'] : 0; ?>"
                            min="0"
                        >
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Hot Americano</td>
                    <td>RM9.00</td>
                    <td>RM8.90</td>
                    <td>RM9.00</td>
                    <td>
                        <input
                            type="number"
                            name="qha"
                            value="<?php echo isset($_SESSION['qha']) ? $_SESSION['qha'] : 0; ?>"
                            min="0"
                        >
                    </td>
                </tr>
            </table>

            <br>

            <input type="submit" name="page1" value="Confirm Order">
        </form>

        <br>

        <form>
            <input type="submit" name="submit" value="Reset Order">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['page1'])) {
            echo $message;
        }
        ?>
    </body>
</html>
