<style>

	.setting-main {
		background-color: darkgray;
    padding: 1em 1em 2em 1em;
	}

	#datepicker {
    text-align: center;
    width: 100px;
    border: 0;
    background: transparent;
    height: 30px;
    color: mediumblue;
    font-weight: bold;
    font-size: 18px;
    margin-left: 1em;
    margin-right: 1em;
	}

	input:focus {
		outline: none;
	}

	button {
		width: 60px;
	}

	.change-status {
		border: 0; 
    width: 30px;
    text-align: center;
    margin-right: 1em;
	}

	table {
		border:1px solid #b3adad;
		border-collapse:collapse;
		padding:5px;
	}
	table th {
		border:1px solid #b3adad;
		padding:5px;
		background: #f0f0f0;
		color: #313030;
	}
	table td {
		border:1px solid #b3adad;
		text-align:center;
		padding:5px;
		background: #ffffff;
		color: #313030;
	}
</style>

<body style="margin: 0; font-family: sans-serif;">
	<div class="setting-top">
		<h1 style="color: red;">データ変更</h1>
		<div style="display: flex; align-items: center; justify-content: center; padding: 1em 1em; background-color: palegoldenrod;">
			<span>日付選択</span>
			<input type="text" id="datepicker">
			<button id="btn-select-date" style="width: 60px;">確認</button>
		</div>
	</div>

	<div class="setting-main">
		<table id="datetable">
			<thead>
				<tr>
					<th>ブース名</th>
					<th>ブース状況</th>
					<th>ブース種類</th>
					<th>性別</th>
					<th>価格</th>
					<th>入場時間</th>
					<th>終了時間</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(count($page_data) > 0) {
						foreach($page_data as $row) {?>
						<tr>
							<td><?php echo $row['booth_name'];?></td>
							<td><input id="trac_id" type="hidden" value="<?php echo $row['id'];?>"><input id="booth_id" type="hidden" value="<?php echo $row['booth_id'];?>"><input type="text" id="status_val" class="change-status" value="<?php echo $row['status'];?>"><button class="btn-change-status">変更</button></td>
							<td><?php echo $row['booth_type'];?></td>
							<td><?php echo $row['gender'];?></td>
							<td><?php echo $row['price'];?></td>
							<td><?php echo $row['entrance_time'];?></td>
							<td><?php echo $row['exit_time'];?></td>
						</tr>
					<?php }} else { ?>
							<tr>
								<td style ='padding: 2em 1em;' colspan='7'>
									<span>選択した日付に対応するデータは存在しません。</span>
								</td>
							</tr>
					<?php }?>
			</tbody>
		</table>
	</div>

	<script type="text/javascript">

		$('.btn-change-status').click( function () {
				var trac_id = $(this).closest('td').find('#trac_id').val();
				var booth_id = $(this).closest('td').find('#booth_id').val();
				var status = $(this).closest('td').find('#status_val').val();

		    $.ajax({
					url: '<?= base_url(); ?>update-transaction',
					type: 'post',
					data: {
						'trac_id' : trac_id,	
						'booth_id': booth_id,
						'status': status,
					},
					dataType: 'json',
					success: function(data) {
						alert('正確に変更されました。');
						// console.log(data);
					},
					error: function(data) {
						console.log(data);
					}
				});


		});
		
		$('#btn-select-date').click( function() {

			var jsDate = $('#datepicker').datepicker('getDate');
			if (jsDate !== null) { // if any date selected in datepicker
			    jsDate instanceof Date; // -> true
			    jsDate.getDate();
			    jsDate.getMonth();
			    jsDate.getFullYear();

			    $.ajax({
						url: '<?= base_url(); ?>get-transactions-date',
						type: 'post',
						data: {
							'date': jsDate.getDate(),
							'month': jsDate.getMonth(),
							'year': jsDate.getFullYear(),
						},
						dataType: 'json',
						success: function(data) {
							$('#datetable tbody').html('');
							console.log(data);
							var str = "";
							if(data.length > 0) {
								data.forEach(
									element => {
										str += "<tr><td>" + element['booth_name'] + "</td>";
										str += "<td>" + "<input id='booth_id' type='hidden' value='" + element['booth_id'] + "'><input type='text' id='status_val' class='change-status' value='" + element['status'] + "'><button class='btn-change-status'>変更</button>" + "</td>";									
										str += "<td>" + element['booth_type'] + "</td>";
										str += "<td>" + element['gender'] + "</td>";
										str += "<td>" + element['price'] + "</td>";
										str += "<td>" + element['entrance_time'] + "</td>";
										str += "<td>" + element['exit_time']  + "</td>";
										 // console.log(str);
								});
							} else {
								str += "<tr><td style ='padding: 2em 1em;' colspan='7'><span>選択した日付に対応するデータは存在しません。</span></td></tr>";
							}

							// console.log(str);

							$('#datetable tbody').html(str);

						},
						error: function(data) {
							console.log(data);
						}
					});
			}

		});

	</script>
</body>