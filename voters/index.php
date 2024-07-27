<?php
require_once("inc/header.php");
require_once("inc/navigation.php");
?>
<div class="row my-3">
    <div class="col-12">
        <h3>Voter Panel</h3>

        <?php
        $fetchingActiveElections=mysqli_query($db, "SELECT *FROM elections WHERE STATUS= 'Active'") or die(mysqli_error($db));
        $totalActiveElections= mysqli_num_rows($fetchingActiveElections);
        if($totalActiveElections>0)

        {
            while($data= mysqli_fetch_assoc($fetchingActiveElections))
            {
                $election_id = $data['id'];
                $election_topic = $data['election_topic'];

                
            ?>  
            <table class="table">
                <thead>
                    <tr>
                        <th class="bg-green" style="color:yellow" colspan="4">
                        <h5>ELECTION TOPIC:  <?php echo strtoupper($election_topic); ?></h5> 
                        </th>
                    </tr>
                    <tr>
                        <th>Photo</th>
                        <th>Candidate Details</th>
                        <th>No of Voters</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    $fetchingCandidates=mysqli_query($db, "select *from candidate_details where election_id= '".$election_id."'")or die(mysqli_error($db));

                    while($candidateData=mysqli_fetch_assoc($fetchingCandidates))
                    {
                    $candidate_id=$candidateData['id'];
                    $candidate_photo =$candidateData['candidate_photo'];
                        //fetching candidate Votes
                $fetchingVotes = mysqli_query($db, "select *from votings where candidate_id ='".$candidate_id."' ") or die(mysqli_error($db));
                $totalVotes = mysqli_num_rows($fetchingVotes);

                    
                    ?>
                        <tr>
                            <td><img src="<?php echo $candidate_photo ?>" class="candidate_photos"/></td>
                            <td><?php echo"<b>". $candidateData['candidate_name']."</b><br/>".$candidateData['candidate_details']; ?></td>
                            <td><?php echo $totalVotes; ?></td>
                            <td>
                                <?php
                            $cheakIfVoteCasted = mysqli_query($db, "SELECT *FROM votings WHERE voters_id = '".$_SESSION['user_id']."' AND election_id='".$election_id."'") or die(mysqli_error($db));
                            $isVoteCasted= mysqli_num_rows($cheakIfVoteCasted);
                            if($isVoteCasted>0)
                            {
                                $voteCastedData=mysqli_fetch_assoc($cheakIfVoteCasted);
                                $voteCastedToCandidate= $voteCastedData['candidate_id'];
                                if($voteCastedToCandidate==$candidate_id)
                                {
                         ?>
                                    <!-- <img src="$" alt="voted" width="100px"> -->
                                    <b>VOTED</b>
                       <?php
                                }
                            }
                            else{
                                ?>
                                    <button class="btn btn-md btn-success" style="background-color: rgb(54,54,199);" onclick="CastVote(<?php  echo $election_id ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)";> Vote </button>
                                <?php
                            }
                            ?>  
                            
                            </td>
                        </tr>
                    <?php
                    }  
                ?>
                </tbody>
        </table>
                <?php
            }
            
            ?>
                
            <?php
        }
        else{
            echo "No any Active ELECTION";
        }
        ?>


        
    </div>
</div>

<script>
        const CastVote=(election_id, customer_id, voters_id)=>
        {
            
            $.ajax({
            type: "POST",
            url:"inc/ajaxCalls.php",
            data: "e_id=" +election_id + "&c_id="+ customer_id + "&v_id=" +voters_id,
            success: function(response) {
                
                if(response== "success")
                {
                    location.assign("index.php?voteCasted=1")
                }
                else{
                    location.assign("index.php?voteNotCasted=1");
                }
            }
            })
        }
</script>



<?php

require_once("inc/footer.php");

?>