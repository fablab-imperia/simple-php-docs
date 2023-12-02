# Simple PHP docs

Una semplice wiki realizzata pro bono per [Fablab Imperia](https://fablabimperia.org).

- [x] render articoli da file markdown
- [x] interpretazione frontmatter
- [x] pagine di inserimento articoli
- [x] restituzione immagini
- [x] caricamento immagini
- [x] intra link
- [x] inserire misure di sicurezza con .htaccess
- [x] ricerca testuale client-side


# Installazione
Copiare tutto il contenuto del repository nella cartella desiderata sul server.

Aprire il file `private/CONST.php` e modificare il valore di `SITE_NAME` e `SITE_URL` per corrispondere al proprio sito.
Sostituire l'immagine `assets/logo.png` con il proprio logo.

Il repository fornisce già alcuni file `.htaccess` nelle cartelle `content` e `private`, per impedire l'accesso.
Bisogna aggiungere un altro file .htaccess e .htpasswd per restringere l'accesso in modifica.

Esempio `.htaccess`:
```
<FilesMatch "^(img_upload\.php|page_create\.php|page_edit\.php)$">
AuthType basic
AuthName "zona admin"
AuthUserFile percorso_assoluto_del_file_htpasswd
Require valid-user
</FilesMatch>
```


# Uso
È possibile modificare gli articoli in formato Markdown direttamente dall'interfaccia web. Prontuario sull'uso di markdown [qui](https://www.markdownguide.org/cheat-sheet/).

## Link interni e immagini
Per inserire link interni ad altre pagine interne oppure a immagini caricate dall'interfaccia web, usare queste scorciatoie.

```
// Per immagini caricate nella pagina attuale
IMG[testo alternativo](nome file immagine)

// Per intra link ad altra pagine della wiki
LINK[testo mostrato](percorso pagina interna, separato da pipe "|")
```


# Note copyright

Software pubblicato con licenza AGPL, versione 3 o successiva. Di seguito i dettagli:

This is NOT public domain, make sure to respect the license terms.

You can find the license text in the COPYING file.

Copyright © 2023 Massimo Gismondi

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU Affero General Public License along with this program. If not, see https://www.gnu.org/licenses/.



## Dipendenze/Dependencies
Questo software utilizza alcune dipendenze esterne, di cui si riportano le note di copyright:

- foglio di stile [SimpleCSS](https://simplecss.org/) nel file `assets/simple.css` è stato realizzato da Kev Quirk, pubblicato con licenza MIT(expat).
- libreria [Parsedown](https://github.com/erusev/parsedown), i cui file sono inclusi nella cartella "parsedown-1.7.4". La libreria Parsedown è pubblicata con licenza MIT(expat), reperibile sul suo repository ufficiale come da link precedente.
- libreria [lunrjs](https://lunrjs.com/), nel file `assets/lunr.js`, licenza MIT(expat), Copyright © 2020 Oliver Nightingale
- icona lente d'ingrandimento, pubblico dominio, creata da [Deferman e Sarang](https://commons.wikimedia.org/wiki/File:Magnifying_glass_icon.svg)



