
# User guide for the ElasticExportTreepodiaCOM plugin

<div class="container-toc"></div>

## 1 Registering with treepodia.com

Treepodia offers the possibility to automatically create product videos from item images and to integrate them in the SingleArticle layout of store items.

## 2 Setting up the data format TreepodiaCOM-Plugin in plentymarkets

The plugin Elastic Export is required to use this format.

Refer to the [Exporting data formats for price search engines](https://knowledge.plentymarkets.com/en/basics/data-exchange/exporting-data#30) page of the manual for further details about the individual format settings.

The following table lists details for settings, format settings and recommended item filters for the format **TreepodiaCOM-Plugin**.
<table>
    <tr>
        <th>
            Settings
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Settings
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            Choose <b>TreepodiaCOM-Plugin</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Provisioning
        </td>
        <td>
            Choose <b>URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            File name
        </td>
        <td>
            The file name must have the ending <b>.xml</b> for treepodia to be able to import the file successfully.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Item filter
        </td>
    </tr>
    <tr>
        <td>
            Active
        </td>
        <td>
            Choose <b>active</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Markets
        </td>
        <td>
            Choose one or multiple order referrer. The chosen order referrer has to be active at the variation for the item to be exported.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Format settings
        </td>
    </tr>
    <tr>
        <td>
            Order referrer
        </td>
        <td>
        	Choose the order referrer that should be assigned during the order import.
        </td>        
    </tr>
    <tr>
        <td>
            Preview text
        </td>
        <td>
        	This option does not affect this format.
        </td>        
    </tr>
    <tr>
		<td>
			Barcode
		</td>
		<td>
			This option does not affect this format.
		</td>        
	</tr>
    <tr>
        <td>
            Image
        </td>
        <td>
            Choose <b>First image</b>.
        </td>        
    </tr>
    <tr>
        <td>
            RRP
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
    <tr>
        <td>
            MwSt.-Hinweis
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
    <tr>
        <td>
            Override item availabilty
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
</table>

## 3 Overview of available XML tags
<table>
    <tr>
        <th>
            Tag description
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td>
            sku
        </td>
        <td>
            <b>Required</b><br>
            The <b>SKU</b> of the variation based on the chosen order referrer in the format settings.
        </td>        
    </tr>
    <tr>
        <td>
            price.value
        </td>
        <td>
            The <b>retail price</b>.
        </td>        
    </tr>
    <tr>
		<td>
			price.sale
		</td>
		<td>
			The <b>sales price</b>.
		</td>        
	</tr>
    <tr>
        <td>
            name
        </td>
        <td>
            <b>Required</b><br>
            The <b>name</b> of the item depending on the chosen format setting <b>Item name</b>.
        </td>        
    </tr>
    <tr>
        <td>
            category
        </td>
        <td>
            <b>Required</b><br>
            The <b>category path of the default category</b> for the defined client in the format settings.
        </td>        
    </tr>
    <tr>
        <td>
            description
        </td>
        <td>
        	<b>Required</b><br>
            According to the format setting <b>description</b>.
        </td>        
    </tr>
    <tr>
        <td>
            brand.name
        </td>
        <td>
            The <b>name of the manufacturer</b> of the item. The <b>external name</b> within the menu <b>Settings » Items » Manufacturer</b> will be preferred if existing.
        </td>        
    </tr>
    <tr>
		<td>
			brand.logo
		</td>
		<td>
			The <b>logo of the manufacturer</b> of the item.
		</td>        
	</tr>
    <tr>
        <td>
            page-url
        </td>
        <td>
        	<b>Required</b><br>
            The product URL according to the format setting <b>product URL</b> and <b>order referrer</b>.
        </td>        
    </tr>
    <tr>
        <td>
            image-url
        </td>
        <td>
        	URL of the image according to the format setting <b>Image</b>. Variation images are prioritized over item images.
        </td>        
    </tr>
    <tr>
        <td>
            attribute.name
        </td>
        <td>
            The attribute name of the item variation.
        </td>        
    </tr>
    <tr>
		<td>
			attribute.value
		</td>
		<td>
			The attribute value name of the item variation.
		</td>        
	</tr>
    <tr>
        <td>
            catch-phrase
        </td>
        <td>
            The freetext fields 1, 2, 3 and 4 which are configured for the item.
        </td>        
    </tr>
    <tr>
        <td>
            shipping
        </td>
        <td>
            According to the format setting <b>shipping costs</b>.
        </td>        
    </tr>
    <tr>
        <td>
            tags
        </td>
        <td>
            The configured keywords for the item.
        </td>        
    </tr>
</table>

## 4 Licence

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-treepodia-com/blob/master/LICENSE.md).