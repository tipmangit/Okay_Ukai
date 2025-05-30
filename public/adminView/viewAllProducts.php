<div>
  <h2>Product Items</h2>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Product Image</th>
        <th class="text-center">Product Name</th>
        <th class="text-center">Unit Price</th>
        <th class="text-center">Product Link</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <?php
      include_once "../php/config.php";
      $sql = "SELECT * FROM product";
      $result = $con->query($sql);
      $count = 1;
      if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
    ?>
    <tr>
      <td class="text-center"><?=$count?></td>
      <td class="text-center"><img height='100px' src='<?=$row["product_image"]?>'></td>
      <td class="text-center"><?=$row["product_name"]?></td>
      <td class="text-center"><?=$row["price"]?></td>  
      <td class="text-center"><?=$row["link"]?></td>   
      <td class="text-center">
        <button class="btn btn-primary" style="height:40px" onclick="itemEditForm('<?=$row['product_id']?>')">Edit</button>
      </td>
      <td class="text-center">
        <button class="btn btn-danger" style="height:40px" onclick="itemDelete('<?=$row['product_id']?>')">Delete</button>
      </td>
    </tr>
    <?php
        $count++;
        }
      }
    ?>
  </table>

  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add Product
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Product Item</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
        <form enctype='multipart/form-data' onsubmit="return addItems()" method="POST">
            <div class="form-group">
              <label for="name">Product Name:</label>
              <input type="text" class="form-control" id="p_name" required>
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" class="form-control" id="p_price" required>
            </div>
            <div class="form-group">
              <label for="link">Product Link:</label>
              <input type="text" class="form-control" id="p_link" required>
            </div>
            <div class="form-group">
              <label for="file">Choose Image:</label>
              <input type="file" class="form-control-file" id="file">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" id="upload" style="height:40px">Add Item</button>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>

    </div>
  </div>
</div>
