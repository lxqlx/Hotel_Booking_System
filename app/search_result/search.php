<?php
	function ifRoomType(){
		return 
		(!empty($_GET['SingleRoom'])) or 
		(!empty($_GET['DoubleRoom'])) or 
		(!empty($_GET['TripleRoom']));
	}
	function ifHotelRate(){
		return 
		(!empty($_GET['ThreeStar'])) or 
		(!empty($_GET['FourStar'])) or 
		(!empty($_GET['FiveStar']));
	}
	function ifPrice(){
		return 
		(!empty($_GET['Range1'])) or 
		(!empty($_GET['Range2'])) or 
		(!empty($_GET['Range3'])) or 
		(!empty($_GET['Range4'])) or 
		(!empty($_GET['Range5']));
	}
	function ifFacility(){
		return 
		(!empty($_GET['Restaurant'])) or 
		(!empty($_GET['Airport'])) or 
		(!empty($_GET['Parking'])) or 
		(!empty($_GET['Wifi'])) or 
		(!empty($_GET['Swimming'])) or 
		(!empty($_GET['Fitness'])) or 
		(!empty($_GET['OtherFacility']));
	}
	function printRoomType($type, $price, $quantity, $color){
    $Ttype = $type." ".$price." ".$quantity." ";
    print"              
                        <tr class='$color'>
                          <td>$type</td>
                          <td>$price</td>
                          <td>$quantity rooms</td>
                          <td><button class='btn btn-primary' type='submit' name='RoomType' value='$Ttype'>Book</button></td>
                        </tr>
    ";
		
	}

	function printListHotel($hotelName, $hotelAddr, $hotelPh, $imgSrc, $rating, $facility, $typeArray, $startDate, $endDate){
		if($imgSrc == "") $imgSrc = 'holder.js/150x150';

		// $startDate = '';
		// if (!empty($_GET["StartDate"])) $startDate = "value='".$_GET["StartDate"]."'";
		// $endDate = '';
		// if (!empty($_GET["EndDate"])) $endDate = "value='".$_GET["EndDate"]."'";
    $faci = array('Restaurant','Airport','Parking','Wifi','Swimming','Fitness');
    $style = array('default', 'primary', 'success', 'info', 'warning', 'danger');
		
		print "
			 <a class='list-group-item'>
                  <div class='panel panel-default'>
                    <!-- Default panel contents -->
                    <div class='panel-heading'>
                      <h4>$hotelName</h4>
                    </div>
                    <div class='panel-body'>

                      <div class='row'>
                        <div class='col-md-3'>
                          <img src='$imgSrc'>
                        </div>
                        <div class='col-md-6'>
                          <form class='form-signin'>
                          <br>Rating: <button class='btn btn-warning' type='button' name='Stars' value='$rating'>$rating <span class=\"glyphicon glyphicon-star\"></span></button></br>
                          </form>
                          <address>
                            Address:<br>
                            $hotelAddr<br> 
                            <abbr title=\"Phone\">P:</abbr> $hotelPh<br>
                          </address>
                        </div>
                        <div class='col-md-3'>";
                          if(strpos($facility,'1') !== false) print "<span class=\"label label-default\">Restaurant</span></br>";
                          if(strpos($facility,'2') !== false) print "<span class=\"label label-primary\">Airport Shuttle</span></br>";
                          if(strpos($facility,'3') !== false) print "<span class=\"label label-danger\">Parking</span></br>";
                          if(strpos($facility,'4') !== false) print "<span class=\"label label-info\">WiFi</span></br>";
                          if(strpos($facility,'5') !== false) print "<span class=\"label label-warning\">Swimming</span></br>";
                          if(strpos($facility,'6') !== false) print "<span class=\"label label-success\">Fitness Club</span></br>";
    print "
                        </div>
                      </div>
                    </div>
                    <form action='../booking/index.php' class='form-signin' role='form' method='get'>
                      <input type='hidden' name='HotelName' value='$hotelName' />
                      <input type='hidden' name='HotelAddr' value='$hotelAddr' />
                      <input type='hidden' name='StartDate' value='$startDate'/>
                      <input type='hidden' name='EndDate' value='$endDate' />
                      ";
        print
                      "

                      <table class='table'>
                      ";
        print         "
                      <tr class='warning'>
                        <td>Room Type</td>
                        <td>Price(\$SGD/Night)</td>
                        <td>Quantity</td>
                        <td></td>
                      </tr>
                      ";
                      $color = array(0 => 'active',1 => 'success',2 => 'warning');
                      $index = 0;
                      foreach ($typeArray as $key => $value) {
                        printRoomType($value[0], $value[1], $value[2],$color[$index]);
                        $index = ($index+1)%3;
                      }
        print "
                      </table>
                    </form>
                  </div>
                  
                </a>
		";
	}

  function eqClause($name, $value, $pre){
    if($name !== 'rating'){
      if (empty($_GET[$value])) return "";
      else return $pre.$name."= '".$_GET[$value]."'";
    }else{
      if (empty($_GET[$value])) return "";
      else return $pre.$name."= ".$_GET[$value];
    }
  }
  function lkClause($name, $value, $pre){
      if (empty($_GET[$value])) return "";
      else return $pre.$name." like '%".$_GET[$value]."%'";
  }

  function genHotelQuery(){
    $_query = "select name, address, country, rating, facility, phone_no, max(price) as mxprice from Hotel,RoomType where Hotel.name=RoomType.hotel_name and Hotel.address=RoomType.hotel_address";
    if (!empty($_GET['Location'])){
      $lstr = str_replace("'","''", $_GET['Location']);
      $_GET['Location'] = strtoupper($lstr);// case incensitive search
      $_query .= " and (".eqClause("upper(country)", "Location",  "")
      .eqClause("upper(city)", "Location", " or ")
      .lkClause("upper(street)", "Location", " or ").")";
    }
    if (!empty($_GET['HotelName'])){
      $lstr = str_replace("'","''",$_GET['HotelName']);
      $_HotelName = strtoupper($lstr);
      $_query .= " and (upper(name) like '%$_HotelName%')";
    }
    if (ifHotelRate()){
      $_subQuery = " and ('true'='false'"
        .eqClause("rating", 'ThreeStar', " or ")
        .eqClause("rating", 'FourStar', " or ")
        .eqClause("rating", 'FiveStar', " or ").")";
      $_query .= $_subQuery;
    }
    if (ifFacility()){
      $_subQuery = " and ('true'='true'"
        .lkClause("facility", 'Restaurant', " and ")
        .lkClause("facility", 'Airport', " and ")
        .lkClause("facility", 'Parking', " and ")
        .lkClause("facility", 'Wifi', " and ")
        .lkClause("facility", 'Swimming', " and ")
        .lkClause("facility", 'Fitness', " and ").")";
      $_query .= $_subQuery;
    }
    return $_query." group by name, address, country, rating, facility, phone_no";
  }

  function genRoomTypeQuery($hotelName, $hotelAddr){
    $_query = "select room_type, AVG(price) as room_price, min(quantity) as room_quantity from RoomType where hotel_name='$hotelName' and hotel_address='$hotelAddr'";
    if (ifRoomType()){
      $_subQuery = " and ( 'true'='false'"
        .eqClause("room_type", 'SingleRoom', " or ")
        .eqClause("room_type", 'DoubleRoom', " or ")
        .eqClause("room_type", 'TripleRoom', " or ").")";
      $_query .= $_subQuery;
    }
    if (ifPrice()){
      $_subQuery = " and ( 'true'='false'";
      if (!empty($_GET['Range1'])) $_subQuery .= " or price<=100";
      if (!empty($_GET['Range2'])) $_subQuery .= " or (price>100 and price<=300)";
      if (!empty($_GET['Range3'])) $_subQuery .= " or (price>300 and price<=500)";
      if (!empty($_GET['Range4'])) $_subQuery .= " or (price>500 and price<=800)";
      if (!empty($_GET['Range5'])) $_subQuery .= " or price>800";
      $_query .= $_subQuery.")";
    }
    if (!empty($_GET['StartDate']) or !empty($_GET['EndDate'])){
      $_subQuery = " and ('true'='true'";
      if (!empty($_GET['StartDate'])){
        $startDate = $_GET['StartDate'];
        $_subQuery .= " and room_date >= to_date('$startDate','MM/DD/YYYY')";
      }

      if (!empty($_GET['EndDate'])){
        $endDate = $_GET['EndDate'];
        $_subQuery .= " and room_date <= to_date('$endDate','MM/DD/YYYY')";
      }
      $_query .= $_subQuery.")";
    }
    $_query .= " group by room_type"." order by room_price";
    return $_query;
  }

  function selectHotels($Hsql){
    //echo "$Hsql<hr>";
    $hotelArray = array();
    putenv('ORACLE_HOME=/oraclient');
    // connect
    $conn = oci_connect('a0091794', 'crse1410', 'sid3');
    //echo "select name from Customer where email='$email' and password='$password'";
    $select= oci_parse($conn, $Hsql);
    oci_execute($select, OCI_DEFAULT);
    while ($row = oci_fetch_array($select)) {
      //name, address, rating, facility, phone_no
      //room_type, room_price, room_quantity
      $name=$row[NAME];
      $addr =$row[ADDRESS];
      $rate =$row[RATING];
      $facility =$row[FACILITY];
      $ph =$row[PHONE_NO];

      $Tsql= genRoomTypeQuery($name, $addr);
      //echo "$Tsql<hr>";
      $Tselect= oci_parse($conn, $Tsql);
      // echo $Tsql;
      // echo '<hr>';
      oci_execute($Tselect, OCI_DEFAULT);
      $roomArray = array();
      while ($Trow = oci_fetch_array($Tselect)) {
        $rType=$Trow[ROOM_TYPE];
        $rPrice=$Trow[ROOM_PRICE];
        $rQuantity=$Trow[ROOM_QUANTITY];
        $rTemp =array($rType, $rPrice, $rQuantity);
        array_push($roomArray, $rTemp);
      }
      if(count($roomArray)!==0){
        $hotel=array(
          'name' =>$name , 
          'addr' =>$addr , 
          'ph' => $ph,
          'rating' =>$rate , 
          'facility' => $facility,
          'types' => $roomArray
        );
        array_push($hotelArray, $hotel);
      }
    }

    // commit
    oci_commit($conn);
    
    // disconnect
    oci_close($conn);
    return $hotelArray;
  }



  function selectHotels2($Hsql, $TNsql){
    //echo "$Hsql<hr>";
    $hotelArray = array();
    putenv('ORACLE_HOME=/oraclient');
    // connect
    $conn = oci_connect('a0091794', 'crse1410', 'sid3');
    //echo "select name from Customer where email='$email' and password='$password'";
    $select= oci_parse($conn, $Hsql);
    oci_execute($select, OCI_DEFAULT);
    while ($row = oci_fetch_array($select)) {
      //name, address, rating, facility, phone_no
      //room_type, room_price, room_quantity
      $name=$row[NAME];
      $addr =$row[ADDRESS];
      $rate =$row[RATING];
      $facility =$row[FACILITY];
      $ph =$row[PHONE_NO];

      $Tsql= str_replace("###", $name, $TNsql);
      $Tsql= str_replace("***", $addr, $Tsql);
      //echo "$Tsql<hr>";
      $Tselect= oci_parse($conn, $Tsql);
      // echo $Tsql;
      // echo '<hr>';
      oci_execute($Tselect, OCI_DEFAULT);
      $roomArray = array();
      while ($Trow = oci_fetch_array($Tselect)) {
        $rType=$Trow[ROOM_TYPE];
        $rPrice=$Trow[ROOM_PRICE];
        $rQuantity=$Trow[ROOM_QUANTITY];
        $rTemp =array($rType, $rPrice, $rQuantity);
        array_push($roomArray, $rTemp);
      }
      if(count($roomArray)!==0){
        $hotel=array(
          'name' =>$name , 
          'addr' =>$addr , 
          'ph' => $ph,
          'rating' =>$rate , 
          'facility' => $facility,
          'types' => $roomArray
        );
        array_push($hotelArray, $hotel);
      }
    }

    // commit
    oci_commit($conn);
    
    // disconnect
    oci_close($conn);
    return $hotelArray;
  }
  // function checkRoomDate($startDate, $endDate, $hotelName, $hotelAddr, $roomType){
  //   $date = $startDate;
    
  //   while (strtotime($date) <= strtotime($endDate)) {
  //     $select_ry = "select * from roomtype where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
      
      
  //     $sth2 = oci_parse($conn, $select_ry);
  //     $suc2 = oci_execute($sth2, OCI_DEFAULT);


  //     if ($row = oci_fetch_array($sth2)){
  //       print_r($row);
  //     }else
  //     {
  //       return false;
  //     }
  //     $date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
  //   }

  //   return true;
  // }
  function getOrderStr($value){
    if($value === "Name") return " Hotel.name,";
    if($value === "Address") return " Hotel.country,";
    if($value === "Rating") return " Hotel.rating,";
    if($value === "Price") return " mxprice,";
    if($value === "Facility") return " length(facility),";
    return "";
  }

?>
