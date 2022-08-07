<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{

    private $questions1of3 = [
        [
            'type' => 1,
            'title' => 'Ik doe alles het liefst zelf, dan weet ik zeker dat het goed gebeurt. Ik heb het ook sneller zelf gedaan.',
        ],
        [
            'type' => 1,
            'title' => 'Ik neem verantwoordelijkheid zeer serieus.',
        ],
        [
            'type' => 1,
            'title' => 'Ik doe meer dan anderen van me verwachten.',
        ],
        [
            'type' => 1,
            'title' => 'Ik besef dat mijn lat hoog ligt (ik vind het belangrijk de dingen god te doen) en daaraan moet ik wel voldoen.',
        ],
        [
            'type' => 1,
            'title' => 'Ik ben kritisch naar mezelf en anderen en wil fouten voorkomen.',
        ],
        [
            'type' => 1,
            'title' => 'Ik heb een soort innerlijk lijstje van wat mag en niet mag.',
        ],
        [
            'type' => 1,
            'title' => 'Ik heb er last van dat de dingen niet zijn zoals ik vind dat ze moeten zijn.',
        ],
        [
            'type' => 1,
            'title' => 'Als iets niet goed gaat heb ik de neiging om boos op mezelf te worden.',
        ],
        [
            'type' => 1,
            'title' => 'Ik vind orde belangrijk.',
        ],

        [
            'type' => 2,
            'title' => 'Ik heb de neiging het anderen naar de zin te maken.',
        ],
        [
            'type' => 2,
            'title' => 'Ik hecht belang aan mijn voorkomen en goede smaak.',
        ],
        [
            'type' => 2,
            'title' => 'Ik krijg een goed gevoel wanneer ik een ander kan helpen.',
        ],
        [
            'type' => 2,
            'title' => 'Ik heb een sterke behoefte aan intimiteit.',
        ],
        [
            'type' => 2,
            'title' => 'Ik heb de neiging te veel voor anderen te doen.',
        ],
        [
            'type' => 2,
            'title' => 'Ik kan moeilijk met afwijzing omgaan.',
        ],
        [
            'type' => 2,
            'title' => 'Ik vind het moeilijk om nee te zeggen.',
        ],
        [
            'type' => 2,
            'title' => 'Ik vind het moeilijk om iemand die belangrijk voor me is af te wijzen.',
        ],
        [
            'type' => 2,
            'title' => 'Ik geef mensen graag advies.',
        ],
        [
            'type' => 3,
            'title' => 'Ik hecht waarde aan succesvol zijn.',
        ],
        [
            'type' => 3,
            'title' => 'Ik ben er goed in de dingen te regelen en organiseren.',
        ],
        [
            'type' => 3,
            'title' => 'Ik ga ervoor om mijn doel te bereiken. Wat we doen moet wel een doel hebben.',
        ],
        [
            'type' => 3,
            'title' => 'Ik kan zo opgaan in mijn werk of mijn rol dat ik vergeet dat er nog meer is in het leven.',
        ],
        [
            'type' => 3,
            'title' => 'Ik vind het leuk wanneer mensen me bewonderen.',
        ],
        [
            'type' => 3,
            'title' => 'Ik ben een zelfbewuste doorzetter.',
        ],
        [
            'type' => 3,
            'title' => 'Ik ben gevoelig voor complimenten.',
        ],
        [
            'type' => 3,
            'title' => 'Ik wil graag winnen.',
        ],
        [
            'type' => 3,
            'title' => 'Ik weet hoe ik een goede indruk kan maken.',
        ],
        [
            'type' => 4,
            'title' => 'Ik word heen en weer geslingerd tussen \'ups\' en \'downs\'.',
        ],
        [
            'type' => 4,
            'title' => 'Ik voel me anders dan anderen.',
        ],
        [
            'type' => 4,
            'title' => 'Ik ben zeer gevoelig, sensitief.',
        ],
        [
            'type' => 4,
            'title' => 'Ik voel me soms onbegrepen.',
        ],
        [
            'type' => 4,
            'title' => 'Ik ben op zoek naar de zin van het bestaan.',
        ],
        [
            'type' => 4,
            'title' => 'Ik voel me aangetrokken tot alles wat intens is.',
        ],
        [
            'type' => 4,
            'title' => 'Ik verlang naar dingen die ontbreken in mijn leven en probeer voortdurend dat gemis te vullen en (onbereikbare) dromen te bereiken.',
        ],
        [
            'type' => 4,
            'title' => 'Ik hecht veel waarde aan echtheid.',
        ],
        [
            'type' => 4,
            'title' => 'Ik houd er niet van mezelf te verliezen in de grijze massa. Ik geef me volledig over aan uitersten.',
        ],
        [
            'type' => 5,
            'title' => 'Ik kan helder en logisch nadenken, snel de hoofd- en bijzaken scheiden.',
        ],
        [
            'type' => 5,
            'title' => 'Ik vind het belangrijk de dingen te begrijpen.',
        ],
        [
            'type' => 5,
            'title' => 'Ik word er wel eens van beschuldigd koel en afstandelijk te zijn.',
        ],
        [
            'type' => 5,
            'title' => 'Ik vind het moeilijk snel te reageren wanneer ik iets niet begrijp.',
        ],
        [
            'type' => 5,
            'title' => 'Ik kan makkelijk mijn gevoel van tijd verliezen als ik geconcentreerd bezig ben. Ik kan ergens helemaal induiken als ik erdoor geobsedeerd ben.',
        ],
        [
            'type' => 5,
            'title' => 'Ik vind het vervelend wanneer anderen zich met mijn privé-zakenbemoeien.',
        ],
        [
            'type' => 5,
            'title' => 'Ik heb moeite mijn gevoelens te delen.',
        ],
        [
            'type' => 5,
            'title' => 'Ik trek me terug wanneer de emoties (hoog) oplopen.',
        ],
        [
            'type' => 5,
            'title' => 'Ik heb veel tijd en ruimte nodig voor mezelf om na te denken.',
        ],
        [
            'type' => 6,
            'title' => 'Ik ben vaak kritisch en ik wil dan eerst de onderste steen boven (dwars).',
        ],
        [
            'type' => 6,
            'title' => 'Ik weet graag alles om zekerheid te hebben, ik houd van duidelijkheid.',
        ],
        [
            'type' => 6,
            'title' => 'Ik twijfel over veel dingen en kan mezelf daardoor ook tegenhouden.',
        ],
        [
            'type' => 6,
            'title' => 'Ik heb de neiging mensen "te toetsen" of ik ze kan vertrouwen.',
        ],
        [
            'type' => 6,
            'title' => 'Ik heb oog voor verborgen agenda\'s. Ik voel aan of \'een zaakje\' te vertrouwen is of niet. Systemen die niet kloppen.',
        ],
        [
            'type' => 6,
            'title' => 'Ik houd niet van veranderingen, ik* stel me moeilijk open voor iets nieuws. *heb geleerd dat openstellen voor nieuwe dingen wel wat brengt, kan brengen.',
        ],
        [
            'type' => 6,
            'title' => 'Ik overzie hoe dingen mis kunnen gaan en anticipeer daarop. Ik heb er oog voor om problemen vroegtijdig te signaleren.',
        ],
        [
            'type' => 6,
            'title' => 'Ik weet vaak wel een uitweg (...) (ik ben een vat vol tegenstrijdigheden.) Ik ben een goede \'scenarioplanner\'.',
        ],
        [
            'type' => 6,
            'title' => 'Ik herken snel de hiërarchie. Ik respecteer het maar soms heb ik ook de neiging om te rebelleren.',
        ],
        [
            'type' => 7,
            'title' => 'Ik* loop het liefst meteen grote boog om pijnen verdriet heen. *zet graag mijn roze bril op.',
        ],
        [
            'type' => 7,
            'title' => 'Ik stop het liefst wanneer ik het niet meer leuk vind om te doen of wanneer ik een betere optie heb.',
        ],
        [
            'type' => 7,
            'title' => 'Ik wou dat mensen wat luchthartiger waren.',
        ],
        [
            'type' => 7,
            'title' => 'Ik heb de neigingproblemen op te lossen met een lach.',
        ],
        [
            'type' => 7,
            'title' => 'Ik ben met veel dingen tegelijk bezig en plan graag leuke dingen (in de toekomst).',
        ],

        [
            'type' => 7,
            'title' => 'Ik kijk naar de zonnige kant van het leven, ik ben eengeboren optimist.',
        ],
        [
            'type' => 7,
            'title' => 'Ik heb eigenlijk geen problemen (en een hekel aan negativiteit).',
        ],
        [
            'type' => 7,
            'title' => 'Ik houd graag alle mogelijkheden open (en houd niet van verplichtingen).',
        ],
        [
            'type' => 7,
            'title' => 'Ik kan me een leven zonder opties niet voorstellen.',
        ],
        [
            'type' => 8,
            'title' => 'Ik vind het belangrijksterk te zijn en mijn zwakte en kwetsbaarheid te verbergen.',
        ],
        [
            'type' => 8,
            'title' => 'Ik ben graag eigen baas en houd ervan de dingen op mijn manier te doen.',
        ],
        [
            'type' => 8,
            'title' => 'Ik heb de neiging te domineren.',
        ],
        [
            'type' => 8,
            'title' => 'Ik eis eerlijkheid.',
        ],
        [
            'type' => 8,
            'title' => 'Ik kan heel goed voor mezelf opkomen en vechten voor datgene wat ik wil.',
        ],
        [
            'type' => 8,
            'title' => 'Ik provoceer mensen om tot ze door te dringen, ze uit hun tent te lokken.',
        ],
        [
            'type' => 8,
            'title' => 'Ik zeg wat ik op mijn lever heb, ik ben recht voor zijn raap.',
        ],
        [
            'type' => 8,
            'title' => 'Ik maak mijn eigen regels.',
        ],
        [
            'type' => 8,
            'title' => 'Ik voel waar iemands zwakke plekken zitten en ook wie de macht heeft.',
        ],
        [
            'type' => 9,
            'title' => 'Ik vindharmonie belangrijk.',
        ],
        [
            'type' => 9,
            'title' => 'Ik vermijd conflicten en ruzie.',
        ],
        [
            'type' => 9,
            'title' => 'Ik geef makkelijker iemand zijn zin dan dat ik een scène schop.',
        ],
        [
            'type' => 9,
            'title' => 'Ik heb moeite mijn eigen grenzen te stellen.',
        ],
        [
            'type' => 9,
            'title' => 'Ik word niet zo makkelijk boos, de meeste mensen maken zich te druk over dingen.',
        ],
        [
            'type' => 9,
            'title' => 'Ik ga snel mee in wat anderen willen en vergeet mezelf dan.',
        ],
        [
            'type' => 9,
            'title' => 'Ik ben over het algemeen rustig, vriendelijk en gemoedelijk.',
        ],
        [
            'type' => 9,
            'title' => 'Ik eis weinig van anderen.',
        ],
        [
            'type' => 9,
            'title' => 'Ik kan iedereen begrijpen en vele gezichtspunten innemen.',
        ],
    ];

    public function show()
    {

        shuffle($this->questions1of3);
        return view('test', [
            'questions' => $this->questions1of3
        ]);
    }
}
