<?php
    $election_id= $_GET['editElection'];
    $fetchingData = mysqli_query($db, "SELECT *FROM elections WHERE id='".$election_id."'") or die();

while ($row=mysqli_fetch_array($fetchingData))
        {  
        
           $election_topic=$row['election_topic'];
        }      
        
?>

<div class="row my-3">
    <div class="col-4">
        <h3>Edit Elections :-</h3><h4><?php echo strtoupper( $election_topic); ?></h4>
        <form method="POST">
            <div class= "form-group">
            <input type="text" name="election_topic" placeholder="Election Topic" class="form-control" required/>
            </div>
            <div class= "form-group">
            <input type="number" name="number_of_candidates" placeholder="No Of Candidates" class="form-control" required/>
            </div>
            <div class= "form-group">
            <input type="text" onfocus="this.type='Date'" name="starting_date" placeholder="Starting Date" class="form-control" required/>
            </div>
            <div class= "form-group">
            <input type="text" onfocus="this.type='Date'" name="ending_date" placeholder="Ending Date" class="form-control" required/>
            </div>
            <input type="submit" value="Add Election" name="addElectionBtn" class="btn btn-success"/>
      </form>
    </div>
</div>
   
    <?php 
      
     
if(isset($_POST['addElectionBtn']))
{
    $election_topic= mysqli_real_escape_string($db,$_POST['election_topic']);
    $number_of_candidates= mysqli_real_escape_string($db,$_POST['number_of_candidates']);
    $starting_date= mysqli_real_escape_string($db,$_POST['starting_date']);
    $ending_date= mysqli_real_escape_string($db,$_POST['ending_date']);
    $inserted_by= $_SESSION['username'];
    $inserted_on = date("y-m-d");

$date1=date_create($inserted_on);
$date2=date_create($starting_date);
$diff=date_diff($date1,$date2);

if((int)$diff->format("%R%a") >0)
{
    $status= "InActive";

}
else{
    $status= "Active";
}

    //inserting into database

    mysqli_query($db, "UPDATE elections SET election_topic= '".$election_topic."',no_of_candidates='".$number_of_candidates."',starting_date='".$starting_date."',ending_date='".$ending_date."',status = '".$status."',inserted_by='".$inserted_by."',inserted_on='".$inserted_on."' WHERE  id =$election_id") or die( mysqli_error($db));

    echo "<script>
    location.assign('index.php?addElectionPage');
</script>";
}

?>
<!-- <script>
    location.assign("index.php?addElectionPage");
</script> -->