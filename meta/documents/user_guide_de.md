
# User Guide für das ElasticExportTreepodiaCOM Plugin

<div class="container-toc"></div>

## 1 Bei Treepodia.com registrieren

Treepodia bietet die Möglichkeit, aus Artikelbildern automatisch erzeugte Produktvideos in die SingleArticle-Ansicht von Webshopartikeln einzubinden.

## 2 Das Format TreepodiaCOM-Plugin in plentymarkets einrichten

Mit der Installation dieses Plugins erhalten Sie das Exportformat **TreepodiaCOM-Plugin**, mit dem Sie Daten über den elastischen Export zu Treepodia übertragen. Um dieses Format für den elastischen Export nutzen zu können, installieren Sie zunächst das Plugin **Elastic Export** aus dem plentyMarketplace, wenn noch nicht geschehen. 

Sobald beide Plugins in Ihrem System installiert sind, kann das Exportformat **TreepodiaCOM-Plugin** erstellt werden. Weitere Informationen finden Sie auf der Handbuchseite [Elastischer Export](https://knowledge.plentymarkets.com/basics/datenaustausch/elastischer-export).

Neues Exportformat erstellen:

1. Öffnen Sie das Menü **Daten » Elastischer Export**.
2. Klicken Sie auf **Neuer Export**.
3. Nehmen Sie die Einstellungen vor. Beachten Sie dazu die Erläuterungen in Tabelle 1.
4. **Speichern** Sie die Einstellungen.
→ Eine ID für das Exportformat **TreepodiaCOM-Plugin** wird vergeben und das Exportformat erscheint in der Übersicht **Exporte**.

In der folgenden Tabelle finden Sie Hinweise zu den einzelnen Formateinstellungen und empfohlenen Artikelfiltern für das Format **TreepodiaCOM-Plugin**.

| **Einstellung**                                     | **Erläuterung**|
| :---                                                | :--- |                                            
| **Einstellungen**                                   | |
| **Name**                                            | Name eingeben. Unter diesem Namen erscheint das Exportformat in der Übersicht im Tab **Exporte**. |
| **Typ**                                             | Typ **Artikel** aus der Dropdown-Liste wählen. |
| **Format**                                          | Das Format **TreepodiaCOM-Plugin** wählen. |
| **Limit**                                           | Zahl eingeben. Wenn mehr als 9999 Datensätze an Treepodia übertragen werden sollen, wird die Ausgabedatei für 24 Stunden nicht noch einmal neu generiert, um Ressourcen zu sparen. Wenn mehr mehr als 9999 Datensätze benötigt werden, muss die Option **Cache-Datei generieren** aktiv sein. |
| **Cache-Datei generieren**                          | Häkchen setzen, wenn mehr als 9999 Datensätze an Treepodia übertragen werden sollen. Um eine optimale Perfomance des elastischen Exports zu gewährleisten, darf diese Option bei maximal 20 Exportformaten aktiv sein. |
| **Bereitstellung**                                  | Die Bereitstellung **URL** wählen. Mit dieser Option kann ein Token für die Authentifizierung generiert werden, damit ein externer Zugriff möglich ist. |
| **Dateiname**                                       | Der Dateiname muss auf **.xml** enden, damit Treepodia die Datei erfolgreich importieren kann. |
| **Token, URL**                                      | Wenn unter Bereitstellung die Option **URL** gewählt wurde, auf **Token generieren** klicken. Der Token wird dann automatisch eingetragen. Die URL wird automatisch eingetragen, wenn unter **Token** der Token generiert wurde. |
| **Artikelfilter**                                   | |
| **Artikelfilter hinzufügen**                        | Artikelfilter aus der Dropdown-Liste wählen und auf **Hinzufügen** klicken. Standardmäßig sind keine Filter voreingestellt. Es ist möglich, alle Artikelfilter aus der Dropdown-Liste nacheinander hinzuzufügen.<br/> **Varianten** = **Alle übertragen** oder **Nur Hauptvarianten übertragen** wählen.<br/> **Märkte** = Eine oder mehrere Auftragsherkünfte wählen. Die gewählten Auftragsherkünfte müssen an der Variante aktiviert sein, damit der Artikel exportiert wird.<br/> **Währung** = Währung wählen.<br/> **Kategorie** = Aktivieren, damit der Artikel mit Kategorieverknüpfung übertragen wird. Es werden nur Artikel, die dieser Kategorie zugehören, übertragen.<br/> **Bild** = Aktivieren, damit der Artikel mit Bild übertragen wird. Es werden nur Artikel mit Bildern übertragen.<br/> **Mandant** = Mandant wählen.<br/> **Markierung 1 - 2** = Markierung wählen.<br/> **Hersteller** = Einen, mehrere oder **ALLE** Hersteller wählen.<br/> **Aktiv** = **Aktiv** wählen. Nur aktive Varianten werden übertragen. |
| **Formateinstellungen**                             | |
| **Produkt-URL**                                     | Wählen, ob die URL des Artikels oder der Variante an Treepodia übertragen wird. Varianten-URLs können nur in Kombination mit dem Ceres Webshop übertragen werden. |
| **Mandant**                                         | Mandant wählen. Diese Einstellung wird für den URL-Aufbau verwendet. |
| **URL-Parameter**                                   | Suffix für die Produkt-URL eingeben, wenn dies für den Export erforderlich ist. Die Produkt-URL wird dann um die eingegebene Zeichenkette erweitert, wenn weiter oben die Option **übertragen** für die Produkt-URL aktiviert wurde. |
| **Auftragsherkunft**                                | Aus der Dropdown-Liste die Auftragsherkunft wählen, die beim Auftragsimport zugeordnet werden soll. |
| **Marktplatzkonto**                                 | Marktplatzkonto aus der Dropdown-Liste wählen. Die Produkt-URL wird um die gewählte Auftragsherkunft erweitert, damit die Verkäufe später analysiert werden können. |
| **Sprache**                                         | Sprache aus der Dropdown-Liste wählen. |
| **Artikelname**                                     | **Name 1**, **Name 2** oder **Name 3** wählen. Die Namen sind im Tab **Texte** eines Artikels gespeichert.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn Rakuten eine Begrenzung der Länge des Artikelnamen beim Export vorgibt. |
| **Vorschautext**                                    | Diese Option ist für dieses Format nicht relevant. |
| **Beschreibung**                                    | Wählen, welcher Text als Beschreibungstext übertragen werden soll.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn Rakuten eine Begrenzung der Länge der Beschreibung beim Export vorgibt.<br/> Option **HTML-Tags entfernen** aktivieren, damit die HTML-Tags beim Export entfernt werden.<br/> Im Feld **Erlaubte HTML-Tags, kommagetrennt (def. Text)** optional die HTML-Tags eingeben, die beim Export erlaubt sind. Wenn mehrere Tags eingegeben werden, mit Komma trennen. |
| **Zielland**                                        | Zielland aus der Dropdown-Liste wählen. |
| **Barcode**                                         | Diese Option ist für dieses Format nicht relevant. |
| **Bild**                                            | **Erstes Bild** wählen. |
| **Bildposition des Energieetiketts**                | Diese Option ist für dieses Format nicht relevant. |
| **Bestandspuffer**                                  | Der Bestandspuffer für Varianten mit der Beschränkung auf den Netto-Warenbestand. |
| **Bestand für Varianten ohne Bestandsbeschränkung** | Der Bestand für Varianten ohne Bestandsbeschränkung. |
| **Bestand für Varianten ohne Bestandsführung**      | Der Bestand für Varianten ohne Bestandsführung. |
| **Währung live umrechnen**                          | Aktivieren, damit der Preis je nach eingestelltem Lieferland in die Währung des Lieferlandes umgerechnet wird. Der Preis muss für die entsprechende Währung freigegeben sein. |
| **Verkaufspreis**                                   | Brutto- oder Nettopreis aus der Dropdown-Liste wählen. |
| **Angebotspreis**                                   | Aktivieren, um den Angebotspreis zu übertragen. |
| **UVP**                                             | Diese Option ist für dieses Format nicht relevant. |
| **Versandkosten**                                   | Aktivieren, damit die Versandkosten aus der Konfiguration übernommen werden. Wenn die Option aktiviert ist, stehen in den beiden Dropdown-Listen Optionen für die Konfiguration und die Zahlungsart zur Verfügung.<br/> Option **Pauschale Versandkosten übertragen** aktivieren, damit die pauschalen Versandkosten übertragen werden. Wenn diese Option aktiviert ist, muss im Feld darunter ein Betrag eingegeben werden. |
| **MwSt.-Hinweis**                                   | Diese Option ist für dieses Format nicht relevant. |
| **Artikelverfügbarkeit überschreiben**              | Diese Option ist für dieses Format nicht relevant. |

_Tab. 1: Einstellungen für das Datenformat **TreepodiaCOM-Plugin**_
 
## 3 Übersicht der verfügbaren XML-Tags

| **Tag-Bezeichnung** | **Erläuterung** |
| :---                | :--- |
| sku                 | **Pflichtfeld**<br/> Die SKU der Variante auf Basis der gewählten Auftragsherkunft in den Formateinstellungen. |
| price.value         | Der Verkaufspreis. |
| price.sale          | Der Angebotspreis. |
| name                | **Pflichtfeld**<br/> Der **Name des Artikels** abhängig von der gewählten Formateinstellung **Artikelname**. |
| category            | **Pflichtfeld**<br/> Der **Kategoriepfad der Standard-Kategorie** für den in den Formateinstellungen definierten Mandanten. |
| description         | **Pflichtfeld**<br/> Entsprechend der Formateinstellung **Beschreibung**. |
| brand.name          | Der **Name des Herstellers** des Artikels. Der **Externe Name** unter **System » Artikel » Hersteller** wird bevorzugt, wenn vorhanden. |
| brand.logo          | Das **Logo des Herstellers** des Artikels. |
| page-url            | **Pflichtfeld**<br/> Die **Produkt-URL** gemäß der Formateinstellung **Produkt-URL** und **Auftragsherkunft**. |
| image-url           | URL zu dem Bild gemäß der Formateinstellung **Bild**. Variantenbilder werden vor Artikelbildern priorisiert. |
| attribute.name      | Der Attributsname der Artikelvariante. |
| attribute.value     | Der Attributswertname des Artikelvariante. |
| catch-phrase        | Die Freitextfelder 1, 2, 3 und 4, falls am Artikel eingestellt. |
| shipping            | Entsprechend der Formateinstellung **Versandkosten**. |
| tags                | Die am Artikel hinterlegten Keywords. | 

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-treepodia-com/blob/master/LICENSE.md).