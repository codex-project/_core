<!--
subtitle: Dev
-->
# dev

```
Codex
- Projects      # collection of Project
-- Project
--- Refs        # collection of Ref
---- Ref
----- Documents # collection of Document
------ Document
```

```
// complete example
/** @var Project */ 
$project = codex()->projects->get('my-project');

/** @var Ref */
$ref = $project->refs->get('1.0.0');

/** @var Document */
$document = $ref->documents->get('index');

// chaining
codex()
    ->projects->get('my-project')
    ->refs->get('1.0.0')
    ->documents->get('index');
    
    
// shorthand resolvers    
$projects   = codex()->get('*');
$project    = codex()->get('my-project');
$refs       = codex()->get('my-project/*');
$ref        = codex()->get('my-project/1.0.0');
$documents  = codex()->get('my-project/1.0.0::*');
$document   = codex()->get('my-project/1.0.0::index');
```