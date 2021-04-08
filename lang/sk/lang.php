<?php

	return [
		'plugin' => [
			'plugin_name' => 'Unique media finder',
			'plugin_description' => 'Rozšírenie na vyhľadávanie fotografií v royalty free databankách.',
			'plugin_desc_settings' => 'Nájdite fotografie v databankách jednoducho a rýchlo.'
		],
		'introduction' => [
			'title' => 'Konfigurácia pluginu',
			'about' => 'Tento plugin bol vytvorený, aby rozšíril funkcionalitu hlavného media manažéru o možnosť vyhľadávania fotorafií v databankách, ktoré ponúkajú fotografie zadarmo.<br/>Pre vyhľadávanie sú používané otvorené API prístupy, takže je nutné, aby ste si vytvorili pre každý endpoint aplikáciu a získali API kľúče.',
			'title_support' => 'Podporte vývoj',
			'support' => 'Ak sa vám tento plugin páči a chceli by ste podporiť jeho ďalší vývoj, prípadne by ste chceli vytvoriť iný, určite pozrite na môj web <a href="https://www.snipi.sk?ref=uniquemediafinder" target="_blank">SNiPI.sk</a> a skúste popremýšľať, ako by ste ma vedeli podporiť napríklad pomocou <a href="https://www.patreon.com/snipiba" target="_blank">patreona</a>.',
			'unsplash_title' => 'Konfigurácia UNSPLASH',
			'unsplash_about' => '<a href="https://unsplash.com/about" target="_blank">UNSPLASH</a> je jednou z mála databánk, ktorá ponúka všetky fotografie zdarma, bez nutnosti určovania zdroja.',
			'unsplash_api_key' => 'Aby ste vedeli vyhľadávať nad databankou, je potrebné aby ste získali <a href="https://unsplash.com/oauth/applications/new" target="_blank">API kľúč</a>. Tento plugin pracuje v READ ONLY móde, takže nebude vytvárať žiadne autorizácie a preto stačí len API kľúč.',
			'pexels_title' => 'Konfigurácia PEXELS',
			'pexels_about' => '<a href="https://www.pexels.com/about/" target="_blank">PEXELS</a> je rovnako jednou z mála databánk, ktorá ponúka kvalitné fotografie a videá, preto som sa rozhodol, že pridám aj tento endpoint.',
			'pexels_api_key' => 'Aby aj toto vyhľadávanie fungovalo korektne, je potrebné získať <a href="https://www.pexels.com/api/" target="_blank">API kľúč</a>. Tento endpoint tiež funguje v READ ONLY móde.',
			'pixabay_title' => 'Configure API settings for PIXABAY',
			'pixabay_about' => '<a href="https://www.pixabay.com/about/" target="_blank">PEXELS</a> is a free photo gallery that provides royalty free stock photos.',
			'pixabay_api_key' => 'For correct searching, you need to create an account and application, to obtain <a href="https://www.pixabay.com/api/" target="_blank">API key</a>. This plugin uses only READ ONLY mode, to browse whole database, then is not needed to use whole API.<br/>If you need step-by-step informations, please, visit my website.'
		],
		'settings' => [
			'tab_unsplash' => 'Unsplash API',
			'tab_pexels' => 'Pexels API',
			'unsplash_api_key' => 'API kľúč',
			'unsplash_api_key_comment' => 'Vložte API kľúč, ktorý ste získali na stránkach UNSPLASH.com',
			'pexels_api_key' => 'API kľúč',
			'pexels_api_key_comment' => 'Vložte API kľúč, ktorý ste získali na stránkach PEXELS.com',
			'unsplash_application_name' => 'Meno aplikácie',
			'unsplash_application_name_comment' => 'Sem vložte názov aplikácie, aký ste zvolili pri tvorbe na stránkach unsplash.com',
			'unsplash_per_page' => 'Počet výsledkov na stránku',
			'pexels_per_page' => 'Počet výsledkov na stránku',
			'unsplash_upload_folder' => 'Ukladať fotky do adresára',
			'unsplash_upload_folder_comment' => 'Zadajte adresár do ktorého chcete fotografie ukladať. Pokiaľ adresár neexistuje, pri prvom stiahnutí fotografie sa automaticky vytvorí.',
			'pexels_upload_folder' => 'Ukladať fotky do adresára',
			'pexels_upload_folder_comment' => 'Zadajte adresár do ktorého chcete fotografie ukladať. Pokiaľ adresár neexistuje, pri prvom stiahnutí fotografie sa automaticky vytvorí.',
			'tab_pixabay' => 'Pixabay API',
			'pixabay_api_key' => 'API key',
			'pixabay_api_key_comment' => 'Enter API key obtained in PEXELS page',
			'pixabay_per_page' => 'Limit results per page',
			'pixabay_upload_folder' => 'Directory to download',
			'pixabay_upload_folder_comment' => 'Select directory in media finder, where files will be downloaded. If folder not exists, it will be created.',
		],
		'forms' => [
			'search_for_photo_hint' => 'Zadajte kľúčové slovo ktoré chcete vyhľadávať nad databankami.',
			'search_for_photo' => 'Vyhľadať',
			'search_photos' => 'Vyhľadať',
			'search_for_photo_modal_title' => 'Vyhľadávanie v databankách',
			'enter_keyword_hit_enter' => 'Napíšte kľúčové slovo a stlačte enter pre začatie hľadania'
 		],
		'errors' => [
			'no_search_query' => 'Chcete, alebo nechcete niečo hľadať?'
		],
		'results' => [
			'found' => '{1}Nájdená jedna fotografia pre |{2,4}Nájdené :count fotografie pre |{5,Inf}Nájdených :count fotografií pre '
		],
		'buttons' => [
			'look' => 'Detail',
			'download' => 'Stiahnuť'
		],
		'flash' => [
			'pic_downloaded' => 'Fotografia bola stiahnutá do adresáru ',
			'pic_error' => 'Niečo sa pokazilo.'
		],
		'photo' => [
			'downloads' => 'Stiahnutí',
			'download_photo' => 'Stiahnuť',
			'views' => 'Zobrazení',
			'updated' => 'Aktualizované',
			'exif_information' => 'Informácie EXIF',
			'dimensions' => 'Rozmery',
			'size' => 'Veľkosť súboru',
			'description' => 'Popis',
			'support_author' => 'Podporte fotografa',
			'no_description_provided' => 'K tejto fotografii nebol vyplnený popis.',
			'support_author_title' => 'Podporte tohto autora ak môžete',
			'support_author_text' => 'Všetky fotografie na stránakch Unsplash.com sú ich autormi ponúkané zdarma a nechcú za to vôbec nič, dokonca ani to, aby ste ich uviedli ako zdroj. Z mojej praxe ako fotografa však viem, že každá podpora práce fotografa je viac ako vítaná, preto ak môžete, skúste skopírovať HTML kód nižšie a vložte ho do vašej stránky kde použijete fotografiu.',
			'provided_by' => 'Táto fotografia je súčasťou ',
			'royalty_free' => ' ~ databanky s fotografiami zdarma.',
			'provider_unsplash' => 'Unsplash.com',
			'provider_pexels' => 'Pexels.com',
			'provider_pixabay' => 'Pixabay.com'
		],
		'exif' => [
			'make' => 'Výrobca fotoaparátu',
			'model' => 'Model fotoaparátu',
			'exposure_time' => 'Expozičný čas',
			'aperture' => 'Clona',
			'focal_length' => 'Ohnisková vzdialenosť',
			'iso' => 'ISO'
		]
	];
