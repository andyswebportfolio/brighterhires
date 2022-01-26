<?php 

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}

/****************************************************************** 
Projectname: Profanity Filter 
Version: 0.2
Author: Mike Block <mikeblock@rogers.com> 
Last modified: 2018-09-28
Copyright (C): 2010 Mike Block, All Rights Reserved 

* GNU General Public License (Version 2, June 1991) 
* 
* This program is free software; you can redistribute 
* it and/or modify it under the terms of the GNU 
* General Public License as published by the Free 
* Software Foundation; either version 2 of the License, 
* or (at your option) any later version. 
* 
* This program is distributed in the hope that it will 
* be useful, but WITHOUT ANY WARRANTY; without even the 
* implied warranty of MERCHANTABILITY or FITNESS FOR A 
* PARTICULAR PURPOSE. See the GNU General Public License 
* for more details. 

Description: 
Builds a list of profane terms and scans a string for matches 
    - returns a rating of the content based on severity ratings and counts 

Change Log: 
=========== 
0.2 Andrew Wells - 2018-09-28
0.1 Mike Block - 2010-02-04 

******************************************************************/ 

class profanityFilter { 
    // construct for holding the wordlist 
    var $wordList; 

    function __construct() { 
        // compile list of words with typography variations 
        $this->_setWordList(); 
    } 
   //
   // Check text against rated terms, count instances, 
   // and apply ratings as a factor to match count 
   // - return total match count 
    
    function scanText($txt) { 
        $profanityCount = 0; 
        $txt = strip_tags($txt); 
        $txt = html_entity_decode($txt,ENT_QUOTES); 
        foreach ($this->wordList as $k=>$v) { 
            preg_match_all("#".$k."(?:es|s)?#si",$txt, $matches, PREG_SET_ORDER); 
            $profanityCount += count($matches)*$v; 
        } 
        return $profanityCount; 
    }


   // compile list of words with typography variations 
   // change ratings as desired to inflate various terms significance 
   // use hyphen to separate common break points in text to catch term variants 

    function _setWordList() { 
        $words = array( 
            "anus"=>1, 
            "arse"=>1, 
            "arse-hole"=>2, 
            "ass"=>1, 
            "ass-bag"=>2, 
            "ass-bandit"=>2, 
            "ass-banger"=>2, 
            "ass-bite"=>2, 
            "ass-clown"=>2, 
            "ass-cock"=>2, 
            "ass-cracker"=>2, 
            "asses"=>1, 
            "ass-face"=>2, 
            "ass-fuck"=>5, 
            "ass-fucker"=>5, 
            "ass-goblin"=>2, 
            "ass-hat"=>2, 
            "ass-head"=>2, 
            "ass-hole"=>3, 
            "ass-hopper"=>2, 
            "ass-jacker"=>2, 
            "ass-lick"=>5, 
            "ass-licker"=>5, 
            "ass-monkey"=>2, 
            "ass-munch"=>5, 
            "ass-muncher"=>5, 
            "ass-nigger"=>5, 
            "ass-pirate"=>2, 
            "ass-shit"=>3, 
            "ass-hole"=>3, 
            "ass-sucker"=>5, 
            "ass-wad"=>3, 
            "ass-wipe"=>3, 
            "bam-pot"=>2, 
            "bastard"=>1, 
            "beaner"=>1, 
            "bitch"=>1, 
            "bitch-ass"=>3, 
            "bitches"=>3, 
            "bitch-tits"=>5, 
            "bitchy"=>1, 
            "blow-job"=>5, 
            "bollocks"=>1, 
            "bollox"=>1, 
            "boner"=>1, 
            "brother-fucker"=>5, 
            "bull-shit"=>1, 
            "bumble-fuck"=>5, 
            "butt-plug"=>5, 
            "butt-pirate"=>5, 
            "butt-fucka"=>5, 
            "butt-fucker"=>5, 
            "camel-toe"=>2, 
            "carpet-muncher"=>3, 
            "chinc"=>1, 
            "chink"=>1, 
            "choad"=>1, 
            "chode"=>1, 
            "clit"=>5, 
            "clit-face"=>5, 
            "clit-fuck"=>5, 
            "cluster-fuck"=>5, 
            "cock"=>3, 
            "cock-ass"=>5, 
            "cock-bite"=>5, 
            "cock-burger"=>5, 
            "cock-face"=>5, 
            "cock-fucker"=>5, 
            "cock-head"=>5, 
            "cock-jockey"=>5, 
            "cock-knoker"=>5, 
            "cock-master"=>5, 
            "cock-mongler"=>5, 
            "cock-mongruel"=>5, 
            "cock-monkey"=>5, 
            "cock-muncher"=>5, 
            "cock-nose"=>5, 
            "cock-nugget"=>5, 
            "cock-shit"=>5, 
            "cock-smith"=>5, 
            "cock-smoker"=>5, 
            "cock-sucker"=>5, 
            "coochie"=>5, 
            "coochy"=>5, 
            "coon"=>2, 
            "cooter"=>1, 
            "cracker"=>1, 
            "cum"=>4, 
            "cumbubble"=>4, 
            "cumdumpster"=>5, 
            "cumguzzler"=>5, 
            "cumjockey"=>5, 
            "cumslut"=>5, 
            "cumtart"=>5, 
            "cunnie"=>4, 
            "cunnilingus"=>3, 
            "cunt"=>5, 
            "cunt-face"=>5, 
            "cunt-hole"=>5, 
            "cunt-licker"=>5, 
            "cunt-rag"=>5, 
            "cunt-slut"=>5, 
            "dago"=>2, 
            "damn"=>0, 
            "deggo"=>2, 
            "dick"=>1, 
            "dick-bag"=>3, 
            "dick-beaters"=>4, 
            "dick-face"=>4, 
            "dick-fuck"=>5, 
            "dick-fucker"=>5, 
            "dick-head"=>4, 
            "dick-hole"=>5, 
            "dick-juice"=>5, 
            "dick-milk"=>5, 
            "dick-monger"=>3, 
            "dicks"=>2, 
            "dick-slap"=>4, 
            "dick-sucker"=>5, 
            "dick-wad"=>3, 
            "dick-weasel"=>5, 
            "dick-weed"=>3, 
            "dick-wod"=>3, 
            "dike"=>2, 
            "dildo"=>3, 
            "dip-shit"=>3, 
            "dooch-bag"=>3, 
            "dookie"=>3, 
            "douche"=>2, 
            "douche-fag"=>5, 
            "douche-bag"=>3, 
            "douche-waffle"=>4, 
            "dum-ass"=>2, 
            "dumb-ass"=>2, 
            "dumb-fuck"=>5, 
            "dumb-shit"=>5, 
            "dum-shit"=>5, 
            "dyke"=>3, 
            "fag"=>3, 
            "fag-bag"=>3, 
            "fag-fucker"=>5, 
            "fag-git"=>4, 
            "faggot"=>4, 
            "faggot-cock"=>5, 
            "fag-tard"=>5, 
            "fat-ass"=>3, 
            "fellatio"=>3, 
            "feltch"=>1, 
            "flamer"=>1, 
            "fuck"=>5, 
            "fuck-ass"=>5, 
            "fuck-bag"=>5, 
            "fuck-boy"=>5, 
            "fuck-brain"=>5, 
            "fuck-butt"=>5, 
            "fucked"=>5, 
            "fucker"=>5, 
            "fucker-sucker"=>5, 
            "fuck-face"=>5, 
            "fuck-head"=>5, 
            "fuck-hole"=>5, 
            "fuckin"=>5, 
            "fucking"=>5, 
            "fuck-nut"=>5, 
            "fuck-nutt"=>5, 
            "fuck-off"=>5, 
            "fucks"=>5, 
            "fuck-stick"=>5, 
            "fuck-tard"=>5, 
            "fuck-up"=>5, 
            "fuck-wad"=>5, 
            "fuck-wit"=>5, 
            "fuck-witt"=>5, 
            "fudge-packer"=>5, 
            "gay"=>1, 
            "gayass"=>5, 
            "gaybob"=>4, 
            "gaydo"=>4, 
            "gay-fuck"=>5, 
            "gay-fuckist"=>5, 
            "gay-lord"=>3, 
            "gay-tard"=>5, 
            "gay-wad"=>5, 
            "god-damn"=>2, 
            "god-damnit"=>2, 
            "gooch"=>2, 
            "gook"=>2, 
            "gringo"=>2, 
            "guido"=>1, 
            "hand-job"=>4, 
            "hard-on"=>1, 
            "heeb"=>1, 
            "hell"=>0, 
            "ho"=>1, 
            "hoe"=>1, 
            "homo"=>2, 
            "homo-dumb-shit"=>5, 
            "honkey"=>2, 
            "humping"=>4, 
            "jackass"=>1, 
            "jap"=>2, 
            "jerk-off"=>3, 
            "jiga-boo"=>3, 
            "jizz"=>4, 
            "jungle-bunny"=>2, 
            "kike"=>3, 
            "kooch"=>4, 
            "kootch"=>4, 
            "kunt"=>5, 
            "kyke"=>3, 
            "lesbian"=>1, 
            "lesbo"=>3, 
            "lezzie"=>2, 
            "mcfagget"=>2, 
            "mick"=>0, 
            "minge"=>2, 
            "motha-fucka"=>5, 
            "mother-fucker"=>5, 
            "mother-fucking"=>5, 
            "muff"=>2, 
            "muff-diver"=>4, 
            "munging"=>1, 
            "negro"=>2, 
            "nigga"=>3, 
            "nigger"=>4, 
            "niggers"=>4, 
            "nig-let"=>3, 
            "nut-sack"=>5, 
            "paki"=>2, 
            "panooch"=>2, 
            "pecker"=>3, 
            "pecker-head"=>4, 
            "penis"=>3, 
            "penis-fucker"=>5, 
            "penis-puffer"=>5, 
            "piss"=>1, 
            "pissed"=>1, 
            "pissed-off"=>2, 
            "piss-flaps"=>4, 
            "pole-smoker"=>4, 
            "pollock"=>2, 
            "poon"=>2, 
            "poonani"=>3, 
            "poonany"=>3, 
            "poontang"=>4, 
            "porch-monkey"=>3, 
            "prick"=>2, 
            "punanny"=>3, 
            "punta"=>3, 
            "pussies"=>4, 
            "pussy"=>4, 
            "pussy-licking"=>5, 
            "puto"=>3, 
            "queef"=>3, 
            "queer"=>2, 
            "queer-bait"=>4, 
            "queer-hole"=>4, 
            "renob"=>2, 
            "rim-job"=>4, 
            "ruski"=>2, 
            "sand-nigger"=>5, 
            "schlong"=>4, 
            "scrote"=>4, 
            "shit"=>2, 
            "shit-ass"=>4, 
            "shit-bag"=>4, 
            "shit-bagger"=>4, 
            "shit-brains"=>4, 
            "shit-breath"=>4, 
            "shit-cunt"=>5, 
            "shit-dick"=>5, 
            "shit-face"=>4, 
            "shit-faced"=>4, 
            "shit-head"=>3, 
            "shit-hole"=>4, 
            "shit-house"=>4, 
            "shit-spitter"=>5, 
            "shit-stain"=>5, 
            "shitter"=>2, 
            "shittiest"=>2, 
            "shitting"=>2, 
            "shitty"=>2, 
            "shiz"=>2, 
            "shiz-nit"=>3, 
            "skank"=>3, 
            "skeet"=>2, 
            "skull-fuck"=>5, 
            "slut"=>3, 
            "slut-bag"=>4, 
            "smeg"=>1, 
            "snatch"=>2, 
            "spic"=>2, 
            "spick"=>2, 
            "splooge"=>4, 
            "tard"=>3, 
            "testicle"=>3, 
            "thunder-cunt"=>5, 
            "tit"=>2, 
            "tit-fuck"=>5, 
            "tits"=>3, 
            "titty-fuck"=>5, 
            "twat"=>4, 
            "twat-lips"=>5, 
            "twats"=>5, 
            "twat-waffle"=>5, 
            "uncle-fucker"=>5, 
            "va-j-j"=>1, 
            "vag"=>2, 
            "vagina"=>2, 
            "vjayjay"=>2, 
            "wank"=>4, 
            "wet-back"=>4, 
            "whore"=>4, 
            "whore-bag"=>5, 
            "whore-face"=>5, 
            "wop"=>2,
            //Extras
            "cuntnugget" =>1,
            "wee" =>1,
            "poo" =>1,
            "bumhole" =>1,
            "cuntwank" =>1
            
        ); 
        $wordsPrepped = array(); 
        foreach ($words as $k=>$v) { 
            $k = str_replace('-','\\W*',$k); 
            $wordsPrepped[$k] = $v; 
        } 
        $this->wordList = $wordsPrepped; 
    } 
}

//finds words inside the string, returns non zero int if any found

?> 