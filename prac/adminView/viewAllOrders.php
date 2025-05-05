<div id="ordersBtn">
  <h2>Order Details</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>O.N.</th>
        <th>Customer</th>
        <th>Username</th>
        <th>Date</th>
        <th>Payment</th>
        <th>Courier</th> 
        <th>Order Status</th>
        <th>Payment Status</th>
        <th>More Details</th>
      </tr> 
    </thead>
    <tbody>
      <?php
      include_once "../php/config2.php";
      
      // Updated query to fetch shipmode from the okay_ukai.orders table
      $sql = "SELECT * FROM orders";
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
      <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["name"] ?></td>
        <td><?= $row["username"] ?></td>
        <td><?= $row["order_date"] ?></td>
        <td><?= $row["pmode"] ?></td>
        <td><?= $row["shipmode"] ?></td> 

        
        <?php 
                if($row["order_status"]==0){
                            
            ?>
                <td><button class="btn btn-danger" onclick="ChangeOrderStatus('<?=$row['id']?>')">Pending </button></td>
            <?php
                        
                }else if($row["order_status"]==1){
            ?>
                <td><button class="btn btn-success" onclick="ChangeOrderStatus('<?=$row['id']?>')">Delivered</button></td>
        
            <?php
            }
                if($row["pay_status"]==0){
            ?>
                <td><button class="btn btn-danger"  onclick="ChangePay('<?=$row['id']?>')">Unpaid</button></td>
            <?php
                        
            }else if($row["pay_status"]==1){
            ?>
                <td><button class="btn btn-success" onclick="ChangePay('<?=$row['id']?>')">Paid </button></td>
            <?php
                }
            ?>
        

        <!-- View Details -->
        <td><button class="btn btn-info" onclick="eachDetailsForm(<?=$row['id']?>)">View Details</button></td>

      </tr>
      <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="viewModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Order Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="order-view-modal modal-body">
        <!-- Loaded via AJAX -->
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.openPopup').on('click', function() {
      var dataURL = $(this).attr('data-href');
      $('.order-view-modal').load(dataURL, function() {
        $('#viewModal').modal({ show: true });
      });
    });
  });
</script>
