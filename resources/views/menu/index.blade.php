@extends('templete.header.base_header')

@section('contents')

<?php

$dsn = "pgsql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE');
$user = env('DB_USERNAME');
$password = env('DB_PASSWORD');
$menus = array();
$numbers = array();
try {
	$dbh = new PDO($dsn, $user, $password);
	$stmt = $dbh->prepare("SELECT * FROM menu_group_master where now() <=  yukoukikan_end_date and sakujo_dt is null");
	$res = $stmt->execute();

	while ($menu_gr = $stmt->fetch()) {
		$menu_grs[] = $menu_gr;
	}

	for ($i = 0; $i <  count($menu_grs); $i++) {
		$stmt = 'stmt' . $i;
		$res = 'res' . $i;
		$menus = 'menus' . $i;
		$$stmt = $dbh->prepare("SELECT * FROM menu_master where now() <=  yukoukikan_end_date and menu_group_cd = :megr and sakujo_dt is null");
		$$stmt->bindValue(':megr', $menu_grs[$i]['menu_group_cd'], PDO::PARAM_STR);
		$$res = $$stmt->execute();

		foreach ($$stmt as $menu) {
			$$menus[] = $menu;
		}
		$numbers[] = $i;
	}
	//データベース接続切断
	$dbh = null;
} catch (PDOException $e) {
	print('Error:' . $e->getMessage());
	die();
}

?>

<body>
	<div class="row">
		<div class="menu_group col-3">
			<?php
			foreach ($menu_grs as $menu_gr) {
			?>
				<button class="col-8 menugr_btn"><?php echo htmlspecialchars($menu_gr['menu_group_name'], ENT_QUOTES, 'UTF-8'); ?></button>
			<?php
			}
			?>
		</div>
		<div class="menu_list_area col-8">
			<form id="frmMenu" action="{{ url('/master') }}" method="POST" target="_blank">
				@csrf
				<input id="targetPage" name="targetPage" type="hidden" value="0000">
				<?php
				for ($i = 0; $i <  count($numbers); $i++) {
					$menus = 'menus' . $i;
				?>
					<div class="menu_list">
						<div class="row">
							<?php
							if (!empty($$menus)) {
								foreach ($$menus as $menu) {
							?>
									<div class="col-4">
										<button name=<?php echo htmlspecialchars($menu['menu_title_url'], ENT_QUOTES, 'UTF-8'); ?> class="col-10 menu_btn"><?php echo htmlspecialchars($menu['menu_title'], ENT_QUOTES, 'UTF-8'); ?></button>
									</div>
								<?php
								}
								?>
						</div>
					</div>
			<?php
							}
						}
			?>
		</div>
		</form>
	</div>
	</div>
	<script src="{{ asset('/js/menu_btn.js') }}"></script>
	<script src="{{ asset('/js/menugr_btn.js') }}"></script>
	</div>
	@endsection
</body>

</html>