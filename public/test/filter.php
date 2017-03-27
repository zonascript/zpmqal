<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <style type="text/css">
    h2 {
      font-family:sans-serif;
    }
    .list {
      font-family:sans-serif;
      margin:0;
      padding:20px 0 0;
    }
    .list > li {
      display:block;
      background-color: #eee;
      padding:10px;
      box-shadow: inset 0 1px 0 #fff;
    }
    .avatar {
      max-width: 150px;
    }
    img {
      max-width: 100%;
    }
    h3 {
      font-size: 16px;
      margin:0 0 0.3rem;
      font-weight: normal;
      font-weight:bold;
    }
    p {
      margin:0;
    }

    input {
      border:solid 1px #ccc;
      border-radius: 5px;
      padding:7px 14px;
      margin-bottom:10px
    }
    input:focus {
      outline:none;
      border-color:#aaa;
    }
    .sort {
      padding:8px 30px;
      border-radius: 6px;
      border:none;
      display:inline-block;
      color:#fff;
      text-decoration: none;
      background-color: #28a8e0;
      height:30px;
    }
    .sort:hover {
      text-decoration: none;
      background-color:#1b8aba;
    }
    .sort:focus {
      outline:none;
    }
    .sort:after {
      width: 0;
      height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-bottom: 5px solid transparent;
      content:"";
      position: relative;
      top:-10px;
      right:-5px;
    }
    .sort.asc:after {
      width: 0;
      height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-top: 5px solid #fff;
      content:"";
      position: relative;
      top:13px;
      right:-5px;
    }
    .sort.desc:after {
      width: 0;
      height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-bottom: 5px solid #fff;
      content:"";
      position: relative;
      top:-10px;
      right:-5px;
    }
  </style>
</head>
<body>
  <div id="hotels">
    <input class="search" placeholder="Search" />
    <div hidden="">
      <button class="sort" data-sort="">Sort by name</button>
    </div>
    <select class="sort">
      <option value="" selected>Sort by</option>
      <option value="hotelName">Hotel Name</option>
      <option value="price">Price</option>
      <option value="star">Star</option>
    </select>

    <ul class="list">
      <li>
        <h3 class="hotelName">The Umrao</h3>
        <p class="price">5002</p>
        <p class="star">3</p>
      </li>
      <li>
        <h3 class="hotelName">Welcomhotel Dwarka, New Delhi</h3>
        <p class="price">8367</p>
        <p class="star">5</p>
      </li>
      <li>
        <h3 class="hotelName">Lemon Tree Premier, Delhi Airport</h3>
        <p class="price">3978</p>
        <p class="star">4</p>
      </li>
      <li>
        <h3 class="hotelName">Red Fox Hotel, Delhi Airport</h3>
        <p class="price">9676</p>
        <p class="star">2</p>
      </li>
    </ul>
  </div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="http://listjs.com/no-cdn/list.js"></script>
  <script type="text/javascript">
    var options = {
      valueNames: [ 'hotelName', 'price', 'star' ]
    };

    var hotelList = new List('hotels', options);

    $('select.sort').change(function(){
      var selection = $(this).val();
      hotelList.sort(selection);
    });

    // $('button.sort').click(function() {
    //   hotelList.sort($(this).data('sort'));  
    // });

    // $('.selectSort').change(function(){
    //   var selection = $(this).val();
    //   console.log(selection);
    //   // $(this).attr('data-sort', selection);
    //   $('.sort').attr('data-sort', selection);
    //   $('.sort').click();

    //   // hotelList.filter(function (item) {
    //   //   if (item.values().price == selection) {
    //   //     return true;
    //   //   } else {
    //   //     return false;
    //   //   }
    //   // });

    // });

  </script>
</body>
</html>