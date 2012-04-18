<?php
ob_start();
// Only a valid post request can execute functions in this page.
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
	header('Location: ./forbidden.html');
	ob_end_flush();
}

require_once './model/Dbconnection.php';
session_start();
if (!isset($_SESSION['dbconn']))
	$_SESSION['dbconn'] = new Dbconnection(); // If not, establish one.
$dbconn = $_SESSION['dbconn'];
$dbconn->connect(); // Connect to database.

// Count the total number of subscribers in database.
$sqlStatement = "select count(*) from `subscribers`";
$sqlStatement .= " where `deleted` = 0";
$result = $dbconn->query($sqlStatement);
$totalitem = $dbconn->fetchOne($result); // total number of subscribers in database.

// The page to load.
$page = 1;
if (isset($_POST['page']))
{
	if (is_numeric($_POST['page']) && $_POST['page'] > 0)
		$page = $_POST['page'];
}

// Number of subscribers to show per page.
$itemperpage = 25;
if (isset($_POST['itemperpage']))
{
	if (is_numeric($_POST['itemperpage'])
		&& $_GET['itemperpage'] > 0
		&& $_GET['itemperpage'] < $totalitem)
		$page = $_POST['itemperpage'];
}

if (($page - 1) * $itemperpage >= $totalitem)
	$page = 1;
$startIndex = ($page - 1) * $itemperpage;

// Load data
$sqlStatement = 'select `subscriber_id`, `subscriber_email`, `subscriber_name`, `created_date`, `subscribed`, `confirmed_date`, `confirmed` from `subscribers`';
$sqlStatement .= ' where `deleted` = 0';
$sqlStatement .= ' order by `created_date` desc';
$sqlStatement .= ' limit ' . $startIndex . ', ' . $itemperpage;
$result = $dbconn->query($sqlStatement);
$count = 0; // count the number of subscribers displayed in this page.
?>

<form id="subscribers-form" name="subscribers-form" method="post" action="send-mail.php">
<ul>
	<li>
		<ul>
			<?php if ($result): ?>
			<li>
				<input type="button" id="btnSelectAll_top" name="selectAll" value="Select All" />&nbsp;
				<input type="button" id="btnApproveSelected_top" name="approveSelected" value="Approve selected" />&nbsp;
				<input type="button" id="btnDeleteSelected_top" name="deleteSelected" value="Delete selected" />&nbsp;
				<input type="button" id="btnSendSelected_top" name="sendSelected" value="Send mail(s) to selected" />&nbsp;
			</li>
			<?php endif; ?>
		</ul>
		<div class="clearboth"></div>
	</li>
	<li>
		<ul class="table_header">
			<li class="checkbox_col">&nbsp;</li>
			<li class="email_col">Email</li>
			<li class="name_col">Contact Name</li>
			<li class="subscribed_date_col">Subscribed date</li>
			<li class="subscribed_col">Subscription status</li>
			<li class="confirmed_date_col">Confirmation date</li>
			<li class="confirmed_col">Email confirmed</li>
			<li class="operations_col">Operations</li>
		</ul>
		<div class="clearboth"></div>
	</li>
	<li id="subscribers-data">
		<?php
			if (!$result):
				echo 'No subscribers available';
			else:
				while (($subscriber = $dbconn->fetchAssoc($result)) !== null):
					$count++;
		?>
			<ul class="<?php echo ($count % 2 == 0) ? 'even' : 'odd'; ?>_row">
				<li class="checkbox_col">
					<input type="checkbox" name="subscribers[]" id="check_<?php echo $subscriber['subscriber_id']; ?>" value="<?php echo $subscriber['subscriber_email']; ?>" />
				</li>
				<li class="email_col" id="email_<?php echo $subscriber['subscriber_id']; ?>">
					<?php echo $subscriber['subscriber_email']; ?>
				</li>
				<li class="name_col" id="name_<?php echo $subscriber['subscriber_id']; ?>">
					<?php echo $subscriber['subscriber_name']; ?>
				</li>
				<li class="subscribed_date_col">
					<?php echo $subscriber['created_date']; ?>
				</li>
				<li class="subscribed_col">
					<?php echo ($subscriber['subscribed']) ? 'Yes' : 'No'; ?>
				</li>
				<li class="confirmed_date_col">
					<?php echo $subscriber['confirmed_date']; ?>
				</li>
				<li class="confirmed_col">
					<?php echo ($subscriber['confirmed']) ? 'Yes' : 'No'; ?>
				</li>
				<li class="operations_col">
					<a href="javascript: void(0);" title="Approve this email address" id="approve_<?php echo $subscriber['subscriber_id']; ?>" class="approve">
						<img src="/gec/public/images/ok.png" alt="Approve" />
					</a>&nbsp;
					<a href="javascript: void(0);" title="Delete this subscriber" class="delete" id="delete_<?php echo $subscriber['subscriber_id']; ?>">
						<img src="/gec/public/images/close.png" alt="Delete" />
					</a>&nbsp;
					<a href="javascript: void(0);" title="Send an email to this subscriber" id="mail_<?php echo $subscriber['subscriber_id']; ?>" class="send-mail">
						<img src="/gec/public/images/send.png" alt="Send" />
					</a>&nbsp;
				</li>
			</ul>
		<?php
				endwhile;
			endif;
		?>
		<div class="clearboth"></div>
	</li>
	<li>
		<ul id="bottom_panel">
			<?php if ($result): ?>
			<li>
				<input type="button" id="btnSelectAll_bottom" name="selectAll" value="Select All" />&nbsp;
				<input type="button" id="btnApproveSelected_bottom" name="approveSelected" value="Approve selected" />&nbsp;
				<input type="button" id="btnDeleteSelected_bottom" name="deleteSelected" value="Delete selected" />&nbsp;
				<input type="button" id="btnSendSelected_bottom" name="sendSelected" value="Send mail(s) to selected" />&nbsp;
			</li>
			<?php endif; ?>
			<li id="pager">
				<span id="items_count">
					<?php
						if ($totalitem == 0)
							echo '0 subscribers';
						else
							echo ($count == 1) ? '1 / ' . $totalitem . ' is displayed' : $count . ' / ' . $totalitem . ' is displayed';
					?>
				</span>
				<?php if ($startIndex > 0): ?>
					<a id="page_1" href="javascript: void(0);" title="First page">First page</a>&nbsp;
					<a id="page_<?php echo $page - 1; ?>" href="javascript: void(0)" title="Previous page">Previous page</a>&nbsp;
				<?php endif; ?>
				<?php if ($startIndex + $itemperpage < $totalitem): ?>
					<a id="page_<?php echo $page + 1; ?>" href="javascript: void(0);" title="Next page">Next page</a>&nbsp;
					<a id="page_<?php echo ceil($totalitem / $itemperpage); ?>" href="javascript: void(0);" title="Last page">Last page</a>&nbsp;
				<?php endif; ?>
			</li>
		</ul>
	</li>
</ul>
</form>

<?php
	// Disconnect after doing query.
	$dbconn->disconnect();
?>


