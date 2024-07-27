<?php 
$election_id=$_GET['viewResult'];

?>


<div class="row my-3">
<div class="col-12">
    <h3>Election Result</h3>

    <?php
    $fetchingActiveElections=mysqli_query($db, "SELECT *FROM elections WHERE id= '".$election_id."'") or die(mysqli_error($db));
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
                    <th class="bg-green text-white" colspan="4">
                    <h5>ELECTION TOPIC:  <?php echo strtoupper($election_topic); ?></h5> 
                    </th>
                </tr>
                <tr>
                    <th>Photo</th>
                    <th>Candidate Details</th>
                    <th># of Voters</th>
                    <!-- <th>Actions</th> -->
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
    <hr>
    <h3>Voting Details</h3>
     
        <?php 
            $fetchingVoteDetails= mysqli_query($db, "SELECT *FROM  votings WHERE election_id='".$election_id."'");
            $number_of_votes= mysqli_num_rows($fetchingVoteDetails);

            if($number_of_votes>0)
            {   
                $sno=1;
                ?>
                <table class="table">
        <tr>
            <th>S.no</th>
            <th>Voter Namw</th>
            <th>Contact No</th>
            <th>Voted To</th>
            <th>Date</th>
            <th>Time</th>

        </tr>
                <?php
                while($data =mysqli_fetch_assoc($fetchingVoteDetails))
                {   $voters_id=$data['voters_id'];
                    $candidate_id=$data['candidate_id'];
                    $fetchingUsername= mysqli_query($db, "SELECT *FROM users WHERE id='".$voters_id."'") or die(mysqli_error($db));
                    $isDataAvailable= mysqli_num_rows($fetchingUsername);
                    $userData= mysqli_fetch_assoc($fetchingUsername);
                    if($isDataAvailable>0)
                    {
 
                        $username = $userData['username'];
                        $contact_no= $userData['contact_no'];

                    }
                    else{
                        $username="No_Data";
                        $contact_no= $userData['contact_no'];

                    }
                    $fetchingCandidateName= mysqli_query($db, "SELECT *FROM candidate_details WHERE id='".$candidate_id."'") or die(mysqli_error($db));
                    $isDataAvailable= mysqli_num_rows($fetchingCandidateName);
                    $candidateData= mysqli_fetch_assoc($fetchingCandidateName);
                    if($isDataAvailable>0)
                    {
 
                        $candidatename = $candidateData['candidate_name'];
                       

                    }
                    else{
                        $candidatename="No_Data";
                       
                    }
                    ?>
                    <tr>
                        <td><?php echo $sno++;?></td>
                        <td><?php echo $username; ?></td>
                        <td><?php echo $contact_no; ?></td>
                        <td><?php echo $candidatename ?></td>
                        <td><?php echo $data['vote_date']; ?></td>
                        <td><?php echo $data['vote_time']; ?></td>
                    </tr>
                    <?php
                }
                echo "</table>";
            }
            else{
                echo "No any votes Available";
            }
        ?>
     </table>
</div>
</div>
