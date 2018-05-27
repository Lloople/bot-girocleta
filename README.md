## Sobre el projecte

Aquest projecte és sense ànim de lucre, amb finalitat educativa i de benefici social.
Va nèixer a partir d'una necessitat que sentia per mi mateix i va guanyar força a mesura
que ho comentava amb altres usuaris del servei.


# Com interactuar amb el bot de la Girocleta


> Cada cop que el bot et dóna informació sobre una estació, pots clicar a sobre del nom
> d'aquesta per obrir un enllaç a l'aplicació de Google Maps del teu Smartphone i que t'hi
> porti seguint les indicacions.

### Ajuda

Per demanar ajuda, pots llegir aquest document o interactuar amb el bot.
```
/help
ajuda
no se que fer
no se com funciona
no se com va
```

Ens donarà una informació bàsica sobre les diferents opcions que tenim

## Informació de les estacions

Pots registrar una estació com a preferida, d'aquesta manera cada cop que saludis
el bot et donarà informació sobre aquesta estació:
```
/station
hola
estació
```

### Canviar la teva estació preferida

Per canviar d'estació, pots fer-ho amb un dels següents exemples:
```
/start
canviar estació
definir estació
afegir estació
```

### Informació sobre recorreguts

El bot de la girocleta et pot donar informació sobre dues estacions, et diu 
les bicis i les parades de cadascuna i la distància que hi ha entre elles
```
vull anar de Ramon Folch a Catalunya
de lluis pericot a eixample
```

No cal dir el nom de l'estació correcte al 100%, però si força semblant per que el 
bot el pugui reconèixer, per exemple `Ramon F` per Ramon Folch, o `Ramon B` per Ramon Berenguer

### Estacions més properes

Si no saps quines estacions tens més a prop, li pots compartir la teva ubicació.
El bot et mostrarà les 3 estacions que tinguis més properes amb la seva respectiva informació, ordenades per proximitat.

## Recordatoris

El bot té la capacitat d'enviar-te un missatge els dies i l'hora que triïs amb la informació
que vulguis. Per exemple et pot avisar cada matí les bicis lliures que hi ha a l'estació que
tens al costat de casa

### Afegir un recordatori

Per afegir un recordatori cal seguir una sèrie de pasos molt senzills que el bot t'anirà demanant
Tot comença amb:

```
/reminder
afegir recordatori
definir recordatori
crear recordatori
```
El bot et demanarà aleshores que escullis quin tipus de recordatori vols. Per ara suporta `Bicis lliures`
i `Aparcaments lliures`.

A continuació et demanarà per la parada de la qual vols informació, apareixeràn totes en forma de botons
igual que quan esculls una estació preferida

Un cop escollida l'estació, et demanarà l'hora, pots introduir-la en gairebé qualsevol format, aquí tens uns exemples
```
09:00 AM
09 AM
18:00
6 PM
6:00 PM
```
El següent pas són els dies de la setmana que vols el recordatori, el bot t'ofereix tres opcions
predefinides en forma de butons. `Entre setmana` que engloba de dilluns a divendres, `Caps de setmana`
per dissabtes i diumenges, i `Tots els dies` per tota la setmana.

Apart d'aquests butons, pots indicar-li manualment quins dies vols, per exemple
```
dilluns dimarts dijous
dimarts i divendres
dimarts, dijous i dissabte
```

Un cop acabat, el bot t'informarà com ha quedat el recordatori creat

### Llistat de recordatoris

Per conèixer els recordatoris que tenim actius, fem servir un dels següents missatges
```
/reminders
els meus recordatoris
recordatoris
```

### Esborrar un recordatori

Si volem deixar de rebre certs avisos, podem demanar-ho amb
```
/reminderdelete
esborrar recordatori
treure recordatori
oblidar recordatori
```

Ens mostrarà un llistat amb els diferents recordatoris i, un cop en triem un, ens demanarà
confirmació per treure'l.

Un recordatori esborrat no es pot recuperar, però és molt fàcil de tornar a crear si el volem

## Alias

Podem definir un alias per una estació en concret, d'aquesta manera podem demanar informació sobre
una estació de manera molt més senzilla sense haver de recordar el seu nom

### Crear un alias

Un àlias només necessita saber quin text farà servir i a quina estació fa referència.

```
/alias
afegir alias
definir alias
crear alias
```

### Llistat dels alias

Podem veure una llista completa dels alias que hem donat d'alta

```
/aliases
els meus alias
veure alias
```

### Esborrar un alias

Per esborrar un alias només cal dir quin volem eliminar i confirmar l'acció

```
/aliasdelete
esborrar alias
treure alias
oblidar alias
```

## Privacitat de l'usuari

Si volem que el bot de la girocleta no tingui guardada cap informació nostre, podem demanar-ho amb
```
/remove
/forget
/delete
borrar usuari
oblidar usuari
```

Després d'acceptar la confirmació, esborrarà tots els nostres recordatoris i la informació personal del nostre compte.