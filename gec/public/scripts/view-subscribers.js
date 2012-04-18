var requestGetPage = new Request.HTML({
	url: 'subscribers-data.php',
	method: 'post',
	onRequest: function()
	{
		$('page-content').set('html', '<img class="loading" src="/gec/public/images/loading.gif" alt="Please wait..." title="Loading..." />');
	},
	onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript)
	{
		// Get the page content and append it to the page-content div.
		$('page-content').set('html', responseHTML);
		// Add event for pagination anchors.
		var anchors = $('pager').getElements('a');
		anchors.each(function(anchor)
		{
			anchor.addEvent('click', function(event)
			{
				event.stop(); // prevent the browser from following the link in this anchor.
				var page = anchor.get('id').replace('page_', '');
				requestGetPage.send('page=' + page);
			});
		});
		// Select all function.
		$('btnSelectAll_top').addEvent('click', selectAll);
		$('btnSelectAll_bottom').addEvent('click', selectAll);
		// Handle multidelete action.
		$('btnDeleteSelected_top').addEvent('click', function(event)
		{
			event.stop();
			if (confirmDelete_multi())
			{
				$('subscribers-form').set('action', 'delete-subscriber.php');
				$('subscribers-form').submit();
			}
		});
		$('btnDeleteSelected_bottom').addEvent('click', function(event)
		{
			event.stop();
			if (confirmDelete_multi())
			{
				$('subscribers-form').set('action', 'delete-subscriber.php');
				$('subscribers-form').submit();
			}
		});
		// Handle specific subscriber delete action
		var deleteAnchors = $$('a[class=delete]');
		deleteAnchors.each(function(anchor)
		{
			anchor.addEvent('click', function(event)
			{
				event.stop();
				// Uncheck every checkbox.
				var checkboxes = $$('input[name=subscribers[]]');
				checkboxes.each(function(checkbox)
				{
					checkbox.set('checked', '');
				});
				// Get current subscriber's id.
				var id = this.get('id').replace('delete_', '');
				$('check_' + id).set('checked', 'checked');
				if (confirmDelete_single(id))
				{
					$('subscribers-form').set('action', 'delete-subscriber.php');
					$('subscribers-form').submit();
				}
			});
		});
		// Highlight row when hover.
		var rows = $('subscribers-data').getElements('ul');
		rows.each(function(row)
		{
			row.addEvent('mouseover', function(event)
			{
				row.setStyle('background-color', '#212121');
			});
			row.addEvent('mouseout', function(event)
			{
				row.setStyle('background-color', 'inherit');
			});
		});
		// Handle multidelete action.
		$('btnApproveSelected_top').addEvent('click', function(event)
		{
			event.stop();
			if (confirmApprove_multi())
			{
				$('subscribers-form').set('action', 'approve-subscriber.php');
				$('subscribers-form').submit();
			}
		});
		$('btnApproveSelected_bottom').addEvent('click', function(event)
		{
			event.stop();
			if (confirmApprove_multi())
			{
				$('subscribers-form').set('action', 'approve-subscriber.php');
				$('subscribers-form').submit();
			}
		});
		// Handle specific subscriber delete action
		var approveAnchors = $$('a[class=approve]');
		approveAnchors.each(function(anchor)
		{
			anchor.addEvent('click', function(event)
			{
				event.stop();
				// Uncheck every checkbox.
				var checkboxes = $$('input[name=subscribers[]]');
				checkboxes.each(function(checkbox)
				{
					checkbox.set('checked', '');
				});
				// Get current subscriber's id.
				var id = this.get('id').replace('approve_', '');
				$('check_' + id).set('checked', 'checked');
				if (confirmApprove_single(id))
				{
					$('subscribers-form').set('action', 'approve-subscriber.php');
					$('subscribers-form').submit();
				}
			});
		});
	}
});

var selectAll = function()
{
	$$('input[type=checkbox]').set('checked', 'checked');
};

var confirmDelete_multi = function()
{
	return confirm("Are you sure to delete the selected subscriber(s)?");
};

var confirmDelete_single = function(id)
{
	name = '';
	name = $('name_' + id).get('text');
	if (name != '')
		name += ' - ';
	name += $('email_' + id).get('text');
	return confirm("Are you sure to delete this subscriber: " + name + '?');
};

var confirmApprove_multi = function()
{
	return confirm("Are you sure to approve the selected email address(es)?");
};

var confirmApprove_single = function(id)
{
	name = $('email_' + id).get('text');
	return confirm("Are you sure to approve this email address: " + name + '?');
};

window.addEvent('domready', function()
{
	requestGetPage.send();
});
