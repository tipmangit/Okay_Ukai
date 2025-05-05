<div>
  <h2>All Customers</h2>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Name</th>
        <th class="text-center">Username</th>
        <th class="text-center">Contact Number</th>
        <th class="text-center">Joining Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
        include_once("../php/config.php");
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $result = $con->query($sql);
        $count = 1;

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
      ?>
      <tr>
        <td class="text-center"><?= $count ?></td>
        <td class="text-center"><?= htmlspecialchars($row["name"]) ?></td>
        <td class="text-center"><?= htmlspecialchars($row["username"]) ?></td>
        <td class="text-center"><?= htmlspecialchars($row["contact"]) ?></td>
        <td class="text-center"><?= date("F j, Y", strtotime($row["created_at"])) ?></td>
      </tr>
      <?php
              $count++;
          }
        } else {
          echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
        }
      ?>
    </tbody>
  </table>
</div>
