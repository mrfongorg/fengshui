# MyFushi tool contract stub

Updated: 2026-10-22

The site is server-rendered HTML. This branch does not call a JSON API. The JSON later in this note is a proposal for a future backend. Do not point the frontend at those URLs yet.

Brand on any response is MyFushi only.

## Current behavior

| Method | Path | What comes back |
| --- | --- | --- |
| GET | `/` | Home HTML |
| GET | `/disclaimer` | Disclaimer HTML |
| GET | `/privacy` | Privacy HTML |
| GET | `/genkan/`, `/mizumawari/`, `/hikkoshi/` | Cluster index HTML |
| GET | `/genkan/a7`, `/mizumawari/b1`, `/hikkoshi/c1` | Sample article HTML |
| GET | `/tools/honmei-kichihoi` | Empty form |
| GET | `/tools/kichijitsu` | Empty form |
| GET | `/tools/kimon-qa` | Empty form |
| POST | same three tool paths | Validated echo, or field errors |

Content-Type is `text/html`. Every response sends `X-Robots-Tag: noindex, nofollow`.

A GET with `?submit=1` and the same field names still runs the same controller. The forms themselves use POST.

There is no `/v1` route, no `TOOL_API_BASE`, and no client that fetches JSON. The CSRF filter is still off, matching the skeleton. Turn `csrf` on for POST before any submission is stored.

### Shared result rule

Validation failure: HTTP 200, the same form, Japanese field errors, no result panel.

Validation success: HTTP 200, the submitted values echoed in Japanese, and this exact line:

`結果＝参考・計算未實作`

The page must not invent a star, a calendar day, or a kimon judgement.

### T1 `POST /tools/honmei-kichihoi`

| Field | Rule |
| --- | --- |
| `birth_year` | Required integer, 1900–2100 |
| `submit` | `1` |

Echo: the year. Planned later copy, not calculated now: 本命星、今年の吉方位・凶方位、家のどこに効くか.

### T2 `POST /tools/kichijitsu`

| Field | Rule |
| --- | --- |
| `event` | `hikkoshi` (引越し), `nyukyo` (入居・入宅), `keiyaku` (契約・鍵渡し) |
| `year` | Required integer, 2000–2100 |
| `month` | Required integer, 1–12 |
| `submit` | `1` |

Echo: the event label, year, and month. Planned later copy: a list of candidate days and a caution. Not calculated now.

### T3 `POST /tools/kimon-qa`

| Field | Rule |
| --- | --- |
| `entrance` | `yes`, `no`, or `unknown` — 玄関は鬼門（北東）側にありますか |
| `water` | same — トイレや浴室は鬼門側にありますか |
| `furniture` | same — 鬼門側に大きな家具を置く予定はありますか |
| `submit` | `1` |

Echo: each answer as はい／いいえ／わからない. The page says the answers are not a lucky/unlucky verdict. Planned later copy: a short caution list. Not calculated now.

## Proposed JSON (not implemented)

Same fields as the forms. Suggested paths, under a base the backend chooses later:

- `POST /v1/tools/honmei-kichihoi`
- `POST /v1/tools/kichijitsu`
- `POST /v1/tools/kimon-qa`

`Content-Type: application/json`. No browser session.

Until a real engine exists, success should look like this. `result` stays `null`.

```json
{
  "ok": true,
  "tool": "honmei-kichihoi",
  "engine": "unimplemented",
  "request": { "birth_year": 1990 },
  "result": null,
  "message": "結果＝参考・計算未實作"
}
```

`tool` is `honmei-kichihoi`, `kichijitsu`, or `kimon-qa`. `request` echoes the normalized fields.

Validation failure, HTTP 422:

```json
{
  "ok": false,
  "error": {
    "code": "validation_error",
    "fields": {
      "birth_year": "生まれ年は西暦の数字で入力してください。"
    }
  }
}
```

The strings can match the Japanese messages already used on the HTML forms.

### Result shapes for a later engine

These are field lists only. The sample values show the shape. They are not a reading, and the current pages must not display them as one.

T1, when `engine` is no longer `unimplemented`:

```json
{
  "honmei_star": { "name": "" },
  "target_year": 2026,
  "auspicious": [{ "role": "", "direction": "" }],
  "inauspicious": [{ "role": "", "direction": "" }],
  "home_note": ""
}
```

`home_note` is the short 「家のどこに効くか」 line.

T2:

```json
{
  "event": "hikkoshi",
  "year": 2026,
  "month": 4,
  "days": [{ "date": "2026-04-03", "label": "", "note": "" }],
  "caution": ""
}
```

T3:

```json
{
  "answers": { "entrance": "unknown", "water": "no", "furniture": "yes" },
  "summary": "",
  "cautions": [""]
}
```

`summary` and `cautions` stay reference text. They do not state that a direction is lucky or unlucky.

### Backend notes

- Keep the public disclaimer: reference and entertainment, not a professional appraisal, and not a guarantee.
- Do not add image or floor-plan upload in this contract.
- Leave staging responses `noindex`.
- When the HTML forms start storing anything, enable the CSRF filter on POST and keep the field names above so the current forms still match.
