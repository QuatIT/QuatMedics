<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$wrd = $_GET['id'];

if(!empty($wrd)){
$count = 1;
$load_icd = select("SELECT * FROM diseases WHERE id='$wrd' || code='$wrd' || LCASE(name) LIKE '%$wrd%' GROUP BY code");

	?>

<table class="table table-bordered data-table">
	<thead style="font-size:20px;">
		<tr style="font-size:20px;">
			<th></th>
			<th style="font-size:20px;">Code</th>
			<th style="font-size:20px;">Result</th>
			<th style="font-size:20px;">Relation</th>
		</tr>
	</thead>
	<tbody>

<?php
foreach($load_icd as $icd){
$sql = select("SELECT * FROM disease_categories WHERE id='".$icd['ref']."' ");

?>

<tr>
			<td><?php echo $count++; ?></td>
			<td><?php echo highlight_word( $icd['code'], $wrd); ?></td>
			<td><?php echo highlight_word( $icd['name'], $wrd); ?></td>
			<td><?php foreach($sql as $sqrow){ ?>
				<ul>
					<li><?php echo highlight_word( $sqrow['name'], $wrd); ?></li>
				</ul>
				<?php } ?></td>
		</tr>



<?php  } ?>
		</tbody>
</table>

<?php		}else{
	echo 'search not found';
} ?>

