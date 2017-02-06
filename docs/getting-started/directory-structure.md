<!--
title: Directory Structure
subtitle: Getting Started
processors:
  disabled:
    - toc
-->
# Directory Structure

Per default Codex resolves your documentation projects from `resources/docs` (configurable).

- Every folder placed in the documentation root directory resembles a project.
- A project requires a configuration `config.php` file to be placed in the project's root directory.
- Every folder placed in a project's root directory resembles a version (internally named "ref")
- A version directory requires at least a `index.*` and `codex.yml` file.

## Examples

**Explaining** the directories
```text
- resources/docs/
  - project/            # Project directory
    - config.php        # Project configuration file
    - master/           # Version directory (Ref)
      - index.md        # Index document
      - codex.yml       # Ref configuration file
    
```

**Real world example**
```text
- resources/docs/
  - blade-extensions/    
    - config.php        
    - master/            
      - index.md        
      - codex.yml       
    - develop/           
      - index.md        
      - codex.yml       
    - 1.0.0/             
      - index.md        
      - codex.yml       
    - 1.1.0/             
      - index.md        
      - codex.yml       
    
  
  - codex/
    - config.php        
    - master/
      - codex.yml
      - index.md
      - getting-started/
        - directory-structure.md
        - configuration.md
        - installation.md        
    - 1.0.0/             
      - index.md        
      - codex.yml       
    
```