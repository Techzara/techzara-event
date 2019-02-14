
# Techzara Evenement Site

Site pour les évenements du Techzara , Hackathon , Hack For My Nations , Blog , Projects OpenSource

**Installation setup**

```
git clone this_repository
cd this_repository
composer install --prefer-dist
```
Edit database configuration in .env file
```
database dump in data/dump
login : julien:julien
```

Then :
```
php bin/console doctrine:migrations:migrate
```
Run webserver

```
php bin/console server:run
```

## TODO
- Gestion utilisateur ( ADD LIST DELETE UPDATE PROFILE )
- Gestion poste ( ADD LIST DELETE  )
- Gestion évenement ( ADD LIST DELETE UPDATE )
- API -> Indépendance front

## NOMMAGE

**Variable**
- tz_*

**Class**
- TzClass

**class**
- tz_*

**id**
- id-*

**Function && controller**
- tzFunctionName 
- tzControllerName
___
# first-contribution-setup
Ho fanampiana ireo rehetra izay vao hi-contribuer , 
to help another first contribution in opensource project , 
aider les premier pas en contribution sur les projets opensource

Hoantsika rehetra izay vao miana-mamindra amin'ny resaka git , indrindra fa ireo izay mi-contribuer amin'ny projet opensource , matetika misy conflit ilay merge.

Ireto misy process kely arahina.

------------------------------------
Cloneo ilay projet noforkenao ao amin'ny repository anao
```
$ git clone ilay_url_ao_amin_repo_anao
```
Midira ao amin'ilay projet en local anao
```
$ cd ilay_repo
```
Apetraho ao amin'ilay repos local anao ilay url an'ilay projet source mba ho à jour foana ny local anao
```
$ git remote add upstream ilay_url_an_ilay_projet_noforkena
```
Raiso ny modification rehetra any amin'ny upstream
```
$ git fetch upstream
```
Mergeo ao amin'ilay master en local anao ilay upstream raha misy modification
```
$ git merge upstream/master
```
Mi-creeva branche hafa

```
$ git checkout -b "brancheko_vaovao"
```
____

Rehefa izay dia tohizanao ny modif ao amin'ny local anao , rehefa afa-po ianao ao amin'ny local ianao dia pushenao ao amin'ny 
master anao ilay local , alohan'ny i-pushena anefa dia manaova fetch an'ilay upstream foana aloha ( satria mety ho betsaka ny contributeur ary misy mikitika foana ilay repo ).
Raha misy modif dia manao merge indray .
```
$ git fetch upstream
```
Raha misy modif dia mergeo ao amin'ny master anao:
```
$ git merge upstream/brancheko_vaovao
```

Rehefa izay dia akaro amin'izay ilay modif anao:
```
$ git add fichier_no_modifier_nao
$ git commit -m "message commit anao"
$ git push -u origin brancheko_vaovao
```

Vita izay dia manaova pull request amin'ilay branche no-creenao.
Misaotra anao namaky 😉
__________
Fitsipika 
- Miezaka mifanitsy sy mifanoro foana.
- Atao manaraka an'io convention nommage io ny nommage-nao.
- Afaka mandray anjara avokoa izay mazoto.
___


*Made for fun !!!*

