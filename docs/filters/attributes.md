<!--
title: Attributes
subtitle: Filters
-->

# Attributes

### Overview

**API Documentation:** [MarkdownFilter](#phpdoc:popover:Codex\Addons\Filters\AttributesFilter)

The attributes filter will parse and remove the attributes that can be defined each document. You can define 
attributes in any kind of document by specifying it on top. By default it accepts FrontMatter and HTMLDocBlock style definitions.



```markdown
<!--
title: Attributes
subtitle: Filters
author: Robin Radic
-->
The attributes filter will parse and remove the attributes that can be defined each document. You can define 
attributes in any kind of document by specifying it on top. By default it accepts FrontMatter and HTMLDocBlock style definitions.
```


Or if you'd rather use FrontMatter:

```markdown
---
title: Attributes
subtitle: Filters
author: Robin Radic
---
The attributes filter will parse and remove the attributes that can be defined each document. You can define 
attributes in any kind of document by specifying it on top. By default it accepts FrontMatter and HTMLDocBlock style definitions.
```

### Configuration
Below is the default configuration. This goes into your `docs/{project-name}/config.php`
```php
[
    'filters' => [
        'enabled' => ['attributes'],
        'attributes' => [            
            'tags'    => [
                [ 'open' => '<!--*', 'close' => '--*>' ],   // HTMLDocBlock
                [ 'open' => '---', 'close' => '---' ],      // FrontMatter
            ],
            'remove_tags' => true,
            'add_extra_data' => true
        ]            
    ]        
];
```

