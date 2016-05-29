# Template Fallback Sugar

Magento 2 module with a little sugar for block overwriting. For example:
You has overwrited block *Magento\Catalog\Product\View* by block *MyCool\MagentoModule\Block\Product\View*.
In this situation you will have problems with templates, because Magento expects that template for you block is inside module *MyCool_MagentoModule* but actually it inside *Magento_Catalog*.
This module adds template fallback based on your block class hierarchy. So if there is no template file in module *MyCool_MagentoModule* it will fallback to *Magento_Catalog* modules template.