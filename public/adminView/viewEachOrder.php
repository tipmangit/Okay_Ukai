<div class="container">
    <h2>Order Details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Products</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Amount Paid</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include_once "../php/config2.php"; 
                $ID = $_GET['id'];


                $sql = "SELECT products, email, phone, address, amount_paid 
                        FROM orders 
                        WHERE id = $id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $products = $row['products'];
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $address = $row['address'];
                    $amount_paid = $row['amount_paid'];
                    ?>
                    <tr>
                        <td><?= $products ?></td>
                        <td><?= $email ?></td>
                        <td><?= $phone ?></td>
                        <td><?= $address ?></td>
                        <td><?= $amount_paid ?></td>
                    </tr>
                    <?php
                } else {
                    echo "<tr><td colspan='5'>No order details found.</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>