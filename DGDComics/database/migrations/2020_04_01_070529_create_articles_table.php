<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('article_text');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
        DB::table('articles')->insert([
            ['user_id' => '4', 'title' => 'One piece: il manga dei record.', 'article_text' => '<p><strong>One Piece</strong> <em>(ONE PIECE - ワンピース Wan Pīsu?)</em> &egrave; un manga scritto e disegnato da <strong>Eiichirō Oda</strong>, serializzato sulla rivista<strong> Weekly Shōnen Jump</strong> di <strong>Shūeisha</strong> dal 22 luglio 1997.</p><p>La casa editrice ne raccoglie periodicamente i capitoli in volumi formato tankōbon, di cui il primo &egrave; stato pubblicato il 24 dicembre. L\'edizione italiana &egrave; curata da <strong>Star Comics</strong>, che ne ha iniziato la pubblicazione in albi corrispondenti ai volumi giapponesi il 1&ordm; luglio 2001.</p><p>La storia segue le avventure di <strong>Monkey D. Rufy</strong>, un ragazzo il cui corpo ha assunto le propriet&agrave; della gomma dopo aver inavvertitamente ingerito il frutto del diavolo Gom Gom. Raccogliendo attorno a s&eacute; una ciurma, Rufy esplora la Rotta Maggiore in cerca del leggendario tesoro One Piece e inseguendo il sogno di diventare il nuovo Re dei pirati.</p><p>One Piece &egrave; adattato in una serie televisiva anime, prodotta da <strong>Toei Animation</strong> e trasmessa in Giappone su <strong>Fuji TV</strong> dal 20 ottobre 1999. L\'edizione italiana &egrave; edita da <strong>Merak Film</strong> ed &egrave; andata in onda su Italia 1 dal 5 novembre 2001 per poi continuare su Italia 2 nel 2012; inizialmente intitolata <em>All\'arrembaggio!</em>, la serie ha avuto diversi cambi di denominazione nel corso delle stagioni, fino ad assestarsi sull\'originale <em>One Piece</em>. Toei Animation ha prodotto inoltre 13 special televisivi, 14 film anime, due cortometraggi 3D, un ONA e un OAV.</p><p>Svariate compagnie ne hanno tratto merchandise di vario genere, come colonne sonore, videogiochi e giocattoli. One Piece ha goduto di uno straordinario successo. Diversi volumi del manga hanno infranto record di vendite e di tiratura iniziale in Giappone. <span style="text-decoration: underline;">Con oltre 470 milioni di copie in circolazione al 2020, &egrave; il manga ad avere venduto di pi&ugrave; al mondo.</span> Il 15 giugno 2015 &egrave; entrato inoltre nel Guinness dei primati come serie a fumetti disegnata da un singolo autore con il maggior numero di copie pubblicate: oltre 320 milioni!</p>'],
            ['user_id' => '4', 'title' => 'Dylan Dog,  l\'investigatore "dell\'incubo"', 'article_text' => '<p><strong>Dylan Dog</strong> &egrave; un personaggio dei fumetti creato da <strong>Tiziano Sclavi</strong> ed elaborato graficamente da <strong>Claudio Villa</strong>, protagonista dell\'omonima serie di genere horror edita dal 1986 dalla<strong> Daim Press</strong> che poi divenne la <strong>Sergio Bonelli Editore</strong>.</p><p>La serie ha raggiunto presto un successo tale da renderlo uno dei fumetti italiani pi&ugrave; venduti, oggetto di numerose ristampe e considerato un <span style="text-decoration: underline;">cult del fumetto italiano</span>. Gli albi della serie a fumetti sono tradotti e pubblicati anche all\'estero. Al personaggio &egrave; ispirato un film omonimo del 2010. La gestazione del personaggio inizi&ograve; nel 1985 quando <strong>Sergio Bonelli</strong>, proprietario della casa editrice, e <strong>Decio Canzio</strong>, suo direttore generale, decisero di tornare a occuparsi di fumetti tradizionali dopo la chiusura dell\'esperienza dei fumetti d\'autore della "<strong>Bonelli-Dargaud</strong>". Sclavi propose quindi un fumetto horror, provvisoriamente chiamato "Dylan Dog". Il nome derivava da <strong>Dylan Thomas</strong>, mentre il cognome dal titolo di un libro di<strong> Mickey Spillane</strong> che Sclavi vide in una libreria (<em>Dog figlio di</em>) ed era il nome provvisorio che dava ai suoi personaggi in fase di creazione per poi cambiarlo una volta completato; l\'aveva usato anche come titolo di una breve storia della fine degli anni settanta disegnata da <strong>Lorenzo Mattotti</strong>.</p><p>Nella prima bozza la nuova serie horror della Bonelli avrebbe dovuto essere ambientata in America, ispirata al genere hard boiled e Dylan avrebbe dovuto essere un detective solitario, senza spalla comica. Si decise di ambientarlo a Londra discutendone con Bonelli perch&eacute; in America, a New York, c\'era gi&agrave; <strong>Martin Myst&egrave;re</strong> e poi l\'Inghilterra sembrava pi&ugrave; adatta per l\'horror per via delle sue antiche tradizioni. Per non rendere la serie troppo incentrata sulle indagini si decise di inserire una spalla comica. La serie venne quindi ambientata nella Londra contemporanea e con protagonista un giovane investigatore "<em>dell\'incubo</em>" (l\'idea ha un precedente in <strong>John Silence</strong>, personaggio dello scrittore inglese<strong> Algernon Blackwood</strong>) dall\'et&agrave; di una trentina d\'anni e, per scelta di Sclavi, con le fattezze ispirate a quelle dell\'attore Rupert Everett. L\'assistente di Dog viene chiamato semplicemente Groucho ed &egrave; sosia dell\'attore Groucho Marx, oltre ad avere la caratteristica di fare continuamente battute o raccontare barzellette in qualsiasi situazione.</p><p>Graficamente il personaggio fu creato da Claudio Villa e Sclavi in proposito racconta:</p><blockquote><p><em>&laquo;abbiamo chiamato [&hellip;] Claudio Villa, e gli abbiamo detto fai delle prove. E lui ha fatto un personaggio che sembrava [&hellip;] un ballerino spagnolo, [&hellip;] e dico, no, non ci siamo, non ci siamo... Poi mi &egrave; venuto in mente, dico, guarda, ieri sera ho visto un film, che non c\'entra assolutamente niente, Another Country - La scelta. [&hellip;] Vai, vai al cinema, [&hellip;] guarda il film, e tira gi&ugrave; quella faccia l&igrave;, che secondo me &egrave; una faccia interessante. Lui &egrave; andato al cinema, [&hellip;] al buio ha fatto Rupert Everett. [&hellip;] gli ho detto non farmelo cos&igrave; effeminato: un po\' pi&ugrave; "macho". Sebbene l\'equivoco e l\'ambiguit&agrave; di Rupert Everett, sia rimasta tutta in Dylan Dog&raquo;.</em></p></blockquote><p>A fine settembre del 1986 usc&igrave; in edicola il primo numero di Dylan Dog ma l\'esordio non fu dei migliori tanto che, citando le parole di Decio Canzio, all\'epoca Direttore responsabile della testata:</p><blockquote><p><em>"Un paio di giorni dopo, il distributore telefon&ograve; &laquo;L\'albo &egrave; morto in edicola, un fiasco&raquo;. A Sclavi fu tenuta pietosamente nascosta l\'orrenda notizia. Qualche settimana dopo, un\'altra telefonata del distributore &laquo;&Egrave; un boom, praticamente esaurito, forse dovremo ristamparlo&raquo;".</em></p></blockquote><p>Tuttavia il vero successo doveva ancora venire. Infatti nel giro di pochi anni Dylan Dog diventa un best seller che porta Sclavi nel 1990 a vincere il premio Yellow Kid come miglior autore. Il 1991 &egrave; probabilmente il momento di maggior successo per la serie che, con il n. 69 "Caccia alle streghe", arriva a superare <strong>Tex</strong> per numero di copie vendute.</p>'],
            ['user_id' => '4', 'title' => 'Il mondo di Fullmetal Alchemist.', 'article_text' => '<p><strong>Fullmetal Alchemist</strong> <em>(鋼の錬金術師 Hagane no renkinjutsushi, lett. "L\'alchimista d\'acciaio")</em> &egrave; un manga scritto e disegnato da<strong> Hiromu Arakawa</strong>.</p><p>L\'opera &egrave; stata serializzata sulla rivista di <strong>Square Enix Monthly Shōnen Gangan</strong> dal 12 luglio 2001 al 12 giugno 2010 per un totale di 108 capitoli pi&ugrave; un capitolo speciale; questi sono in seguito stati raccolti in 27 volumi sotto l\'etichetta <strong>Gangan Comics</strong> e pubblicati tra il 22 gennaio 2002 e il 22 novembre 2010. Il manga &egrave; stato tradotto in diverse lingue, tra cui in italiano da <strong>Planet Manga</strong>, in inglese da<strong> Viz Media</strong>, in francese da <strong>Kurokawa</strong>, in spagnolo da <strong>Norma Editorial</strong> e in coreano da <strong>Haksan Publishing</strong>.</p><p>La storia segue i giovani alchimisti <strong>Edward</strong> e <strong>Alphonse Elric</strong>, due fratelli in viaggio per la nazione di <strong>Amestris</strong> alla ricerca della leggendaria pietra filosofale con lo scopo di riottenere i loro corpi originari persi in una trasmutazione umana finita male. Durante il loro viaggio scopriranno un piano orchestrato da sette esseri chiamati <strong>homunculus</strong> che potrebbe distruggere il Paese se non fermati in tempo.</p><p>Dal manga sono state tratte due serie televisive anime prodotte dallo studio d\'animazione <strong>Bones</strong>: <strong>Fullmetal Alchemist</strong> <em>(鋼の錬金術師 Hagane no renkinjutsushi)</em> conta 51 episodi, trasmessi tra il 2003 ed il 2004, e traspone fedelmente il manga solo per i primi volumi, narrando poi una storia originale;<strong> Fullmetal Alchemist: Brotherhood</strong><em> (鋼の錬金術師 FULLMETAL ALCHEMIST Hagane no renkinjutsushi - FULLMETAL ALCHEMIST)</em>, &egrave; un adattamento fedele del manga in 64 episodi, mandati in onda tra il 2009 ed il 2010. La serie ha avuto un enorme successo, generando anche altri adattamenti, tra cui film animati, romanzi e videogiochi.</p><p>L\'universo di Fullmetal Alchemist, ambientato nei primi anni del 1900, diverge dal nostro principalmente per la presenza dell\'alchimia: questa &egrave; una scienza che utilizza l\'energia scaturita dai movimenti della crosta terrestre e la incanala tramite un cerchio alchemico per compiere un processo chiamato trasmutazione, ovvero la modifica delle propriet&agrave; di un oggetto. La trasmutazione si divide in tre fasi principali: la comprensione della struttura della materia, la scomposizione e la ricomposizione. Inoltre l\'alchimia &egrave; governata da una legge che si pone come caposaldo di questa scienza: il principio dello scambio equivalente, il quale impone che, durante una trasmutazione, la massa dell\'oggetto di base e quello trasmutato debbano essere identici, cos&igrave; come le propriet&agrave; dei due oggetti. Coloro che riescono ad utilizzare l\'alchimia assumono la denominazione di alchimisti. La nazione in cui si svolgono le vicende &egrave; Amestris, un Paese governato da un regime militare il cui capo &egrave; chiamato "comandante supremo"; la vocazione militaristica di Amestris si rivela anche nel fatto che la nazione &egrave; periodicamente in guerra con diversi Stati confinanti ed &egrave; stata teatro di una sanguinosa guerra civile. Il Paese viene diviso essenzialmente in cinque regioni, ognuna corrispondente ad un punto cardinale pi&ugrave; il centro, che ospita la capitale Central City. Oltre che ai soldati, i quali sono divisi in gradi da recluta a generale, l\'ingresso nell\'esercito &egrave; aperto anche agli alchimisti che, dopo aver superato un test, ottengono il titolo di alchimista di Stato, un grado equivalente a quello di maggiore e fondi illimitati per le loro ricerche, ma con l\'obbligo di scendere in guerra e di seguire tre regole principali: non trasmutare l\'oro, non effettuare trasmutazioni umane e giurare fedelt&agrave; all\'esercito.</p>'],
            ['user_id' => '4', 'title' => 'Superman: il primo degli eroi.', 'article_text' => '<p><strong>Superman</strong>, il cui nome kryptoniano &egrave; <strong>Kal-El</strong>, mentre il suo nome terrestre &egrave; <strong>Clark Kent</strong>, &egrave; un personaggio dei fumetti creato da <strong>Jerry Siegel</strong> e <strong>Joe Shuster</strong> nel 1933, ma pubblicato dalla<strong> DC Comics</strong> soltanto nel 1938 poich&eacute; prima il personaggio aveva una propria testata firmata dagli autori; <span style="text-decoration: underline;">&egrave; il primo supereroe della storia dei fumetti</span> ed &egrave; soprannominato anche <strong>Man of Steel</strong> oppure <strong>The Man of Tomorrow</strong>. Noto in Italia in passato anche come Ciclone, l\'uomo fenomeno, l&rsquo;Uomo d\'acciaio e Nembo Kid.</p><p><em>Un uomo in grado di sollevare un\'auto, con un costume blu addosso e un mantello rosso, contornato da un gruppo di passanti impauriti</em>: &egrave; questa la prima immagine di Superman, quella con cui fa il suo esordio nelle edicole statunitensi. Nel 2015, il sito web <strong>IGN</strong> ha inserito Superman alla prima posizione nella classifica dei cento maggiori eroi della storia dei fumetti prima di <strong>Batman</strong>. Del personaggio sono state realizzate numerose trasposizioni cinematografiche, televisive, teatrali e radiofoniche.</p><p>L\'interesse per il personaggio negli anni &egrave; rimasto alto tanto che il n. 75 della serie a fumetti nel quale era stato annunciato che il personaggio sarebbe morto, pubblicato nel novembre 1992, ha venduto <span style="text-decoration: underline;">sei milioni di copie</span>.</p>'],
            ['user_id' => '4', 'title' => 'Iron Man, le origini.', 'article_text' => '<p><strong>Iron Man</strong>, il cui vero nome &egrave; <strong>Anthony Edward</strong> "<strong>Tony" Stark</strong>", &egrave; un personaggio dei fumetti creato nel 1963 da<strong> Stan Lee</strong> e <strong>Larry Lieber</strong> (testi), disegnato da <strong>Don Heck</strong> e<strong> Jack Kirby</strong> e pubblicato dalla <strong>Marvel Comics</strong>. La sua prima apparizione avvenne in <strong>Tales of Suspense</strong> (vol. 1[1]) n. 39 (marzo 1963), la cui copertina venne disegnata da Kirby, collaboratore di Heck nello sviluppo del design dell\'armatura.</p><p>Geniale inventore miliardario, playboy e filantropo proprietario delle Stark Industries, Tony viene rapito in Vietnam (Afghanistan dopo la retcon) rimanendo ferito dall\'esplosione di una mina e, anzich&eacute; costruire armi di distruzione di massa come ordinatogli dai suoi carcerieri, sfrutta il periodo della sua prigionia per costruire un\'armatura che possa salvargli la vita e permettergli di fare ritorno in patria, dove assume l\'identit&agrave; di Iron Man divenendo un supereroe nonch&eacute; membro fondatore dei Vendicatori. Contraddistinto dal carattere carismatico e cordiale risulta tuttavia anche bramoso di potere e spesso disposto a usare sotterfugi, menzogne e inganni (anche ai danni dei propri alleati se lo ritiene necessario), prerogative che lo hanno spesso portato a contrasti con supereroi come l\'Uomo Ragno, Thor e soprattutto Capitan America, noti per la spiccata onest&agrave;.</p><p>Nel 2008 la rivista <strong>Forbes</strong> lo ha posizionato al settimo posto nella classifica dei personaggi di fantasia pi&ugrave; ricchi del mondo, attribuendogli un patrimonio di 7,9 miliardi di dollari che, nel 2013, &egrave; stata ricalcolato portandolo a 12,4 miliardi e collocandolo di conseguenza alla quarta posizione della lista. Nella classifica stilata nel 2011 dal sito <strong>IGN</strong>, si &egrave; posizionato al dodicesimo posto come pi&ugrave; grande eroe della storia dei fumetti, dopo <strong>Dick Grayson</strong> e prima di <strong>Jean Grey</strong>.</p>'],
            ['user_id' => '4', 'title' => 'Topolino su wikipedia', 'article_text' => '<p><strong>Topolino</strong> &egrave; il nome di due diverse testate a fumetti pubblicate in Italia: la prima, in formato giornale (pubblicata dal 1932 al 1949)[1] e la seconda, in formato "libretto" e in sostituzione della prima, dal 1949, e cos&igrave; intitolate perch&eacute; incentrate sul personaggio dei fumetti di <strong>Mickey Mouse</strong> noto in Italia come Topolino.</p><p>Il personaggio in Italia esord&igrave; nel 1930 sull\'Illustrazione del Popolo, supplemento della Gazzetta del popolo ma la prima testata omonima arriver&agrave; alla fine del 1932 con il settimanale Topolino edito inizialmente dalla Casa Editrice <strong>Nerbini</strong>&nbsp;e poi dalla <strong>Arnoldo Mondadori Editore</strong>.</p><p>Successivamente questa testata venne chiusa e nel 1949 la Mondadori ne fece esordire un\'altra omonima ma di diverso formato che, dopo cambi di editore, &egrave; ancora in corso di pubblicazione dopo aver <span style="text-decoration: underline;">superato i 3000 numeri</span>.</p>']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}