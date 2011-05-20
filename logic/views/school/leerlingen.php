<!-- validates -->
<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/lln_beheer.png" alt="Leerlingen beheer" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="/school/index/data" name="leerlingen">Mijn leerlingen</a></li>
				<li><a href="/school/index/richting" name="taak_plannen">Taak plannen</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="users_per_school">
				<img src="<?= base_url(); ?>assets/images/mijn_lln.png" alt="Mijn leerlingen" />
				<p class="uitleg">Hier vindt u een overzicht van alle studenten die u begeleidt.</p>
				<table class="tbl_students">
					<tr>
						<th>Achternaam</th>
						<th>Voornaam</th>
						<th>E-mail</th>
						<th>Studierichting</th>
					</tr>
					<? foreach($leerlingen as $leerling): ?>
						<tr>
							<td><?= $leerling['achternaam']; ?></td>
							<td><?= $leerling['voornaam']; ?></td>
							<td><?= $leerling['email']; ?></td>
							<td><?= $leerling['studierichting']; ?></td>
						</tr>
					<? endforeach;?>
				</table>
				<p>todo nieuwe gebruiker toevoegen</p>
			</div>

			<div class="taak_plannen">
				<img src="<?= base_url(); ?>assets/images/plan_taak.png" alt="Taak plannen" />
				<p class="uitleg">Hier kan u een taak plannen voor alle studenten die u begeleidt.</p>
			</div>
		</div>
	</div>
</div>