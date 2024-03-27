<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orders</title> 
</head>   
  
<body>
<h1 style="text-align:center">Order Details</h1>
            
<div class="w100">
  <div class="row">
    <div class="w-sm-3">
        <img src= "https://buvonslocal.pro/static/media/logo.8ebedae0d777ed358225d520cbe8b869.svg" class="float-left ml-4" height="80px" width="160px">
    </div>
    <div class="w-sm-9">
          <div class="row order-details">
          <div class="w-sm-12">
            <h3>Supplier Information</h3>
          </div>
          <div class="col-sm-4">
          <label>Supplier</label>
          <input type="text" name="FirstName" />
        </div>
        <div class="col-sm-4">
          <label>Creation</label>
          <input type="text" name="MiddleName" />
        </div>
        <div class="col-sm-4">
          <label>Order Status</label>
          <input type="text" name="LastName" />
        </div>
        <div class="col-sm-4">
          <label>Expected Delivery Date</label>
          <input type="text" name="LastName" />
        </div>
        <div class="col-sm-8">
          <label>Invoice Status</label>
          <input type="text" name="LastName" />
        </div>
      </div>
      <!--------------retailer information------------>
      
      {{ $order_info->id }}

      <div class="row retailer-order-details">
        <div class="col-sm-12">
          <h3>Rtetailer Information</h3>
        </div>
          <div class="col-sm-3">
          <label>Name</label>
          <input type="text" name="FirstName" value="{{ $order_info->id }}" />
        </div>
        <div class="col-sm-3">
          <label>Phone No.</label>
          <input type="text" name="MiddleName" " />
        </div>
        <div class="col-sm-3">
          <label>Contact email</label>
          <input type="text" name="LastName"  />
        </div>
        <div class="col-sm-3">
          <label>Consumption</label>
          <input type="text" name="LastName"  />
        </div>
        <div class="col-sm-3">
          <label>Business Name</label>
          <input type="text" name="LastName"  />
        </div>
        <div class="col-sm-3">
          <label>order Disrtibuted by</label>
          <input type="text" name="LastName" />
        </div>
      </div>
      <!-------------end retailer information--------------->
</div>
</div>
</div>

        <div>
        <table class="table table-bordered  table-striped mt-2 ">
            <tr style="background-color: #9fe3de; color: #404040" >
                <th></th>
                <th width="40px">ITEM</th>
                <th width="40px">PRICE</th>
                <th>QUANTITY</th>
                <th width="200px">SUBTOTAL</th>
            </tr>
            


        </table>
       

    </div>




           
            
           

           


</body>

</html>