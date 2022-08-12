<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER triggerStarRecensione AFTER INSERT ON `reviews` FOR EACH ROW
                BEGIN
                    UPDATE rankings SET stars_number = stars_number + NEW.stars WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                END'
        );
        DB::unprepared('
            CREATE TRIGGER triggerFeedbackRecensione AFTER INSERT ON `reviews` FOR EACH ROW
                BEGIN
                    UPDATE rankings SET feedback_number = feedback_number + 1 WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                END'
        );
        DB::unprepared('
            CREATE TRIGGER triggerAvgStarsRecensione AFTER INSERT ON `reviews` FOR EACH ROW
                BEGIN
                    UPDATE rankings SET avg_stars = stars_number / feedback_number WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                END'
        );
        DB::unprepared('
            CREATE TRIGGER triggerProducts AFTER INSERT ON `comic_boughts` FOR EACH ROW
                BEGIN
                    UPDATE rankings SET number_selling_products = number_selling_products + New.quantity WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                END'
        );

        DB::unprepared('
            CREATE TRIGGER triggerModRecensione AFTER UPDATE ON `reviews` FOR EACH ROW
                BEGIN
                    IF NEW.stars > OLD.stars THEN
                        UPDATE rankings SET stars_number = (stars_number + (NEW.stars - OLD.stars)) WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                        UPDATE rankings SET avg_stars = stars_number / feedback_number WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                    ELSEIF NEW.stars < OLD.stars THEN
                        UPDATE rankings SET stars_number = (stars_number - ( OLD.stars - NEW.stars)) WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                        UPDATE rankings SET avg_stars = stars_number / feedback_number WHERE user_id = (select comics.user_id from comics WHERE id = NEW.comic_id);
                    END IF;
                END 
        ');

        DB::unprepared('
            CREATE TRIGGER triggerDelRecensione AFTER DELETE ON `reviews` FOR EACH ROW
                BEGIN
                    UPDATE rankings SET stars_number = stars_number - OLD.stars WHERE user_id = (select comics.user_id from comics WHERE id = OLD.comic_id);
                    UPDATE rankings SET feedback_number = feedback_number - 1 WHERE user_id = (select comics.user_id from comics WHERE id = OLD.comic_id);
                END
        ');

        DB::table('reviews')->insert([
            ['comic_id' => '26' , 'user_id' => '3' , 'review_title' => 'Il mio amichevole spidy' , 'review_text' => 'Il miglior spiderman che abbia mai letto! Super Consigliato' , 'stars' => '5'],
            ['comic_id' => '28' , 'user_id' => '3'  , 'review_title' => 'Batman Alla riscossa' , 'review_text' => 'Un batman ritrovato, non nuovo ma ritrovato , finalmente la dc torna alle origini' , 'stars' => '4'],
            ['comic_id' => '34' , 'user_id' => '3'  , 'review_title' => 'Mi aspettavo di più' , 'review_text' => 'Vista la sua fama pensavo ad un manga più avvincente, ma non adoro gli horror' , 'stars' => '2'],
            ['comic_id' => '13' , 'user_id' => '3'  , 'review_title' => 'Il gigante verde spento' , 'review_text' => 'Un hulk troppo stilizzato che non rispecchia le origini del personaggio' , 'stars' => '3'],
            ['comic_id' => '14' , 'user_id' => '3'  , 'review_title' => 'Thor martella di nuovo' , 'review_text' => 'Il figlio di Odino è incredibile in questo fumetto , strepitoso. 5 stelle super meritate' , 'stars' => '5'],
            ['comic_id' => '2' , 'user_id' => '3'  , 'review_title' => 'Tutti vorrebbero essere Stark' , 'review_text' => 'Il fumetto originale che parla della nascita di Iron Man , strepitoso da leggere con gli acdc in sottofondo' , 'stars' => '5'],
            ['comic_id' => '25' , 'user_id' => '3'  , 'review_title' => 'Un Iron man mai visto , in peggio ' , 'review_text' => 'In questo fumetto Tony Stark è diventato troppo potente, talmente potente da essere il cattivo.' , 'stars' => '2'],
            ['comic_id' => '3' , 'user_id' => '3'  , 'review_title' => 'Paperino: il mio alter ego nei fumetti' , 'review_text' => 'Sempre divertente un fumetto per tornare fanciulli e rillasarsi un po' , 'stars' => '5'],
            ['comic_id' => '16' , 'user_id' => '3'  , 'review_title' => 'Topolino Happy Birthday' , 'review_text' => 'Una super collection per celebrare il compleanno di topolino. Molto carino , consigliato!!' , 'stars' => '5'],
            ['comic_id' => '26' , 'user_id' => '6' , 'review_title' => 'delusione' , 'review_text' => 'Il peggior spiderman che abbia mai letto! Non Consigliato' , 'stars' => '2'],
            ['comic_id' => '28' , 'user_id' => '6'  , 'review_title' => 'Batman, Spettacolare' , 'review_text' => 'Un batman super, finalmente il personaggio torna alla grande' , 'stars' => '5'],
            ['comic_id' => '34' , 'user_id' => '6'  , 'review_title' => 'Un grande classico' , 'review_text' => 'Un classico per gli amanti del manga , super consigliato!' , 'stars' => '4'],
            ['comic_id' => '13' , 'user_id' => '6'  , 'review_title' => 'Hulk is back' , 'review_text' => 'Un hulk nuovo , personalmente più avvinciente del passato' , 'stars' => '4'],
            ['comic_id' => '14' , 'user_id' => '6'  , 'review_title' => 'Thor, una certezza' , 'review_text' => 'Il mio personaggio preferito nei fumetti, peccato che rispecchia poco la vera mitologia norrena' , 'stars' => '4'],
            ['comic_id' => '2' , 'user_id' => '6'  , 'review_title' => 'Semplicemente Iron man' , 'review_text' => 'Il fumetto originale della sua nascita, da qui i Marvel studios hanno preso spunto per il primo film! ' , 'stars' => '4'],
            ['comic_id' => '25' , 'user_id' => '6'  , 'review_title' => 'Uno strano personaggio ' , 'review_text' => 'Nel fumetto è Tony ad essere il cattivo. Non mi piace un miliardario cattivo! Metto 3 stelle solo per la spedizione super veloce' , 'stars' => '3'],
            ['comic_id' => '26' , 'user_id' => '7' , 'review_title' => 'Spiderman!' , 'review_text' => 'Il fumetto delle origini , il miglior spiderman di sempre! Super Consigliato , spedizione un po lenta' , 'stars' => '4'],
            ['comic_id' => '28' , 'user_id' => '7'  , 'review_title' => 'Batman again' , 'review_text' => 'Batman is back,finalmente ritrovato , lo aspettavo da tempo!' , 'stars' => '5'],
            ['comic_id' => '34' , 'user_id' => '7'  , 'review_title' => 'Una storia pazzesca' , 'review_text' => 'Adoro i manga, adoro gli horror , questo è il fumetto fatto su misura per me! Fantastico! ' , 'stars' => '5'],
            ['comic_id' => '13' , 'user_id' => '7'  , 'review_title' => 'È, o non è Hulk' , 'review_text' => 'Un hulk troppo lontano dalle origini del personaggio! Non Consigliato!!' , 'stars' => '1'],
            ['comic_id' => '14' , 'user_id' => '7'  , 'review_title' => 'Il dio del Tuono' , 'review_text' => 'Da quando ho iniziato a leggerlo alla fine del fumetto stesso vorrei essere solo stato lui il grande Thor! Spettacolare! ' , 'stars' => '4'],
            ['comic_id' => '2' , 'user_id' => '7'  , 'review_title' => 'Ah tony stark!' , 'review_text' => 'Fumetto eccezionale e strepitoso da leggere e rileggere cento volte, pieno di easter eggs!!' , 'stars' => '5'],
            ['comic_id' => '25' , 'user_id' => '7'  , 'review_title' => 'Non ci siamo Tony!' , 'review_text' => 'il mio amato Iron man reso cattivo da Stan lee , spero in una retromarcia! Non consigliato agli amanti di Iron man!' , 'stars' => '1'],
            ['comic_id' => '1' , 'user_id' => '8' , 'review_title' => 'Il mio primo manga' , 'review_text' => 'È stato il mio primo manga e l\'ho adorato! Eccezionale! Super Consigliato!!!' , 'stars' => '4'],
            ['comic_id' => '35' , 'user_id' => '8'  , 'review_title' => 'Una storia pazzesca' , 'review_text' => 'Adoro i manga, adoro gli horror , questo è il fumetto fatto su misura per me! Fantastico! ' , 'stars' => '5'],
            ['comic_id' => '30' , 'user_id' => '8'  , 'review_title' => 'La laterna torna a slendere' , 'review_text' => 'Un Laterna Verde ritrovato, non nuovo ma ritrovato , finalmente la dc torna alle origini' , 'stars' => '4'],
            ['comic_id' => '5' , 'user_id' => '8'  , 'review_title' => 'È l\'uomo di acciaio' , 'review_text' => 'Un Superman delle origini super consigliato ai fan dell\'uomo d\'acciaio!!!' , 'stars' => '5'],
            ['comic_id' => '6' , 'user_id' => '8'  , 'review_title' => 'Il solito Batman' , 'review_text' => 'Da quando ho iniziato a leggerlo alla fine del fumetto stesso sono stato annoiato!!' , 'stars' => '3'],
            ['comic_id' => '7' , 'user_id' => '8'  , 'review_title' => 'Flash!' , 'review_text' => 'Fumetto eccezzionale e strepitoso da leggere e rileggere cento volte quasi alla velocità della luce!!!' , 'stars' => '5'],
            ['comic_id' => '45' , 'user_id' => '8'  , 'review_title' => 'Strepitoso!' , 'review_text' => 'Il fumetto da qui ha ripreso il film! Strepitoso sia nella storia che nel disegno!' , 'stars' => '5'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger');
    }
}
