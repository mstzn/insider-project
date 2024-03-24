## How to ...?

```
php artisan migrate:fresh --seed
```

```
php artisan serve
```
---
#### Environment Variables
To change number of teams for fixture

`min` of this number or name count on TeamSeeder will be the actual count
```
TOTAL_NUMBER_OF_TEAMS
```
Max goal per match. This is a visual value, not related with simulation logic.
```
MAX_GOAL_PER_MATCH
```
---

#### Get Team List
```
/api/teams
```

#### Generate New Fixture
```
/api/fixtures/generate
```

#### Get All Games for a Fixture
```
/api/fixtures/show/{fixture}
```

#### Get Simulation Screen Data
```
/api/simulation
```

#### Simulate All Weeks
```
/api/simulation/play-all-weeks
```

#### Simulate Next Week
```
/api/simulation/play-next-week
```


