<!-- validates -->
<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/informatie_header.png" alt="Informatie" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="#" name="personal">Tips en technieken</a></li>
				<li><a href="#" name="school">Studieplanner FAQ</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="form_profile" style="display: none">
				<img src="<?= base_url(); ?>assets/images/header_tips.png" alt="Tips en technieken" />
				<ul id="items_list">
					<? foreach($content as $item): ?>
						<li><a href="<?= base_url(); ?>files/<?= $item['content']; ?>"><?= $item['title']; ?></a></li>
					<? endforeach; ?>
				</ul>
			</div>
			<div class="form_school" style="display: block">
				<img src="<?= base_url(); ?>assets/images/faq.png" alt="Faq"  style="margin-bottom: 13px; margin-left: -2px"/>
				
				<h2 class="faq_header">Wat?</h2>
				<p class="faq_item">
					Studieplanner is een leerplatform ontworpen door CLB in samenwerking met Lessius Hogeschool. Op onze website
					kunnen leerlingen begeleidt worden door leerkrachten of studiebegeleiders binnen hun school. De student kan
					worden opgevolgd en er wordt een houvast geboden voor leer- en planningproblemen.
				</p>
				
				<h2 class="faq_header">Hoe?</h2>
				<p class="faq_item">
					Elke student die aan het platform toegevoegd wordt, wordt automatisch begeleid door een leerkracht van zijn of haar
					school. De student kan via de Planner huiswerk en deadlines toevoegen. Deze kunnen worden nagekeken door de coach. De 
					begeleidende leerkracht kan ook taken toevoegen aan de planner, waarvan verwacht wordt dat de student deze uitvoert.
				</p>
				<h2 class="faq_header">Wie?</h2>
				<p class="faq_item">
					Studieplanner wordt beheerd door mensen van het Centrum voor Leerlingenbegeleiding (CLB), maar voornamelijk door de
					leerkrachten van je school. Als je vragen hebt, contacteer je plaatselijk CLB of stel ze aan je begeleidende leerkracht!
				</p>
			</div>
		</div>
	</div>
</div>