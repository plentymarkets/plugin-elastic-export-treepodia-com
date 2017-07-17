
# User Guide für das ElasticExportTreepodiaCOM Plugin

<div class="container-toc"></div>

## 1 Bei Treepodia.com registrieren

Treepodia bietet die Möglichkeit, aus Artikelbildern automatisch erzeugte Produkt-Videos in die SingleArticle-Ansicht von Webshopartikeln einzubinden.

## 2 Das Format TreepodiaCOM-Plugin in plentymarkets einrichten

Um dieses Format nutzen zu können, benötigen Sie das Plugin Elastic Export.

Auf der Handbuchseite [Daten exportieren](https://www.plentymarkets.eu/handbuch/datenaustausch/daten-exportieren/#4) werden die einzelnen Formateinstellungen beschrieben.

In der folgenden Tabelle finden Sie spezifische Hinweise zu den Einstellungen, Formateinstellungen und empfohlenen Artikelfiltern für das Format **TreepodiaCOM-Plugin**. 
<table>
    <tr>
        <th>
            Einstellung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Einstellungen
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            <b>TreepodiaCOM-Plugin</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Bereitstellung
        </td>
        <td>
            <b>URL</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Dateiname
        </td>
        <td>
            Der Dateiname muss auf <b>.xml</b> enden, damit Treepodia die Datei erfolgreich importieren kann.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Artikelfilter
        </td>
    </tr>
    <tr>
        <td>
            Aktiv
        </td>
        <td>
            <b>Aktiv</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Märkte
        </td>
        <td>
            Eine oder mehrere Auftragsherkünfte wählen. Die gewählten Auftragsherkünfte müssen an der Variante aktiviert sein, damit der Artikel exportiert wird.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Formateinstellungen
        </td>
    </tr>
    <tr>
        <td>
            Auftragsherkunft
        </td>
        <td>
            Die Auftragsherkunft wählen, die beim Auftragsimport zugeordnet werden soll.
        </td>        
    </tr>
    <tr>
        <td>
            Vorschautext
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
    <tr>
		<td>
			Barcode
		</td>
		<td>
			Diese Option ist für dieses Format nicht relevant.
		</td>        
	</tr>
    <tr>
        <td>
            Bild
        </td>
        <td>
            <b>Erstes Bild</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            UVP
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
    <tr>
        <td>
            MwSt.-Hinweis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
    <tr>
        <td>
            Artikelverfügbarkeit überschreiben
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
</table>

## 3 Übersicht der verfügbaren XML-Tags
<table>
    <tr>
        <th>
            Tag-Bezeichnung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td>
            sku
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Die <b>SKU</b> der Variante auf Basis der gewählten Auftragsherkunft in den Formateinstellungen.
        </td>        
    </tr>
    <tr>
        <td>
            price.value
        </td>
        <td>
            <b>Inhalt:</b> Der <b>Verkaufspreis</b>.
        </td>        
    </tr>
    <tr>
		<td>
			price.sale
		</td>
		<td>
			<b>Inhalt:</b> Der <b>Angebotspreis</b>.
		</td>        
	</tr>
    <tr>
        <td>
            name
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der <b>Name</b> des Artikels abhängig von der gewählten Formateinstellungen <b>Artikelname</b>.
        </td>        
    </tr>
    <tr>
        <td>
            category
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der <b>Kategoriepfad der Standard-Kategorie</b> für den in den Formateinstellungen definierten <b>Mandanten</b>.
        </td>        
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
        	<b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Beschreibung</b>.
        </td>        
    </tr>
    <tr>
        <td>
            brand.name
        </td>
        <td>
            <b>Inhalt:</b> Der <b>Name des Herstellers</b> des Artikels. Der <b>Externe Name</b> unter <b>Einstellungen » Artikel » Hersteller</b> wird bevorzugt, wenn vorhanden.
        </td>        
    </tr>
    <tr>
		<td>
			brand.logo
		</td>
		<td>
			<b>Inhalt:</b> Das <b>Logo des Herstellers</b> des Artikels.
		</td>        
	</tr>
    <tr>
        <td>
            page-url
        </td>
        <td>
        	<b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Die Produkt-URL gemäß der Formateinstellung <b>Produkt-URL</b> und <b>Auftragsherkunft</b>
        </td>        
    </tr>
    <tr>
        <td>
            image-url
        </td>
        <td>
            <b>Inhalt:</b> URL zu dem Bild gemäß der Formateinstellungen <b>Bild</b>. Variantenbilder werden vor Artikelbildern priorisiert.
        </td>        
    </tr>
    <tr>
        <td>
            attribute.name
        </td>
        <td>
            <b>Inhalt:</b> Der Attributsname der Artikelvariante.
        </td>        
    </tr>
    <tr>
		<td>
			attribute.value
		</td>
		<td>
			<b>Inhalt:</b> Der Attributswertname der Artikelvariante.
		</td>        
	</tr>
    <tr>
        <td>
            catch-phrase
        </td>
        <td>
            <b>Inhalt:</b> Die Freitextfelder 1, 2, 3 und 4, falls am Artikel konfiguriert.
        </td>        
    </tr>
    <tr>
        <td>
            shipping
        </td>
        <td>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Versandkosten</b>.
        </td>        
    </tr>
    <tr>
        <td>
            tags
        </td>
        <td>
            <b>Inhalt:</b> Die am Artikel konfigurierten Keywords.
        </td>        
    </tr>
</table>

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-treepodia-com/blob/master/LICENSE.md).