# 種子內容／Schema 草稿｜日站優先
更新：2026-10-22（Asia/Hong_Kong）｜品牌對外：風水日站（站面唔寫公司名）

## 1 目標
- P0：schema 草稿 + **50–100 條關鍵字簇種子方向**（日站先行）。
- 繁中共用 schema（欄位預留 `locale`）；雙站是否同期＝**D1／D2 待批**。
- 關鍵字證據暫只有 PNG；本表由截圖簇人手整理，**正式 Sheet／CSV 待 D5**。

## 2 Schema（建議 JSON／Sheet 欄）

| 欄位 | 型別 | 說明 |
| --- | --- | --- |
| `id` | string | 穩定 id，如 `jp-genkan-mat-001` |
| `locale` | enum | `ja`｜`zh-Hant-TW`｜`zh-Hant-HK` |
| `cluster` | string | 簇：genkan／wallet_color／plant／car_plate／room_layout／office／tool |
| `primary_kw` | string | 主關鍵字（日文優先） |
| `secondary_kws` | string[] | 相關詞 |
| `intent` | enum | informational｜checklist｜comparison｜tool｜local |
| `title_draft` | string | 自寫標題草稿（非 scraped） |
| `outline` | string | 大綱／H2 列表 |
| `page_type` | enum | article｜checklist｜faq｜tool_landing |
| `ymyl_flag` | bool | 是否需加強免責 |
| `status` | enum | seed｜outlined｜drafted｜published｜blocked |
| `research_refs` | string | 內部 aweme_id／筆記路徑（唔公開） |
| `notes` | string | 編輯備註 |

可選後期：`slug`、`hreflang_group`、`internal_links`、`tool_id`。

## 3 日站種子簇（方向；約 80 條槽位）

### A 玄関／入口（~15）
風水、玄関マット 風水、風水 玄関、玄関 鏡、玄関 観葉植物、靴の向き、玄関 照明、玄関 掃除、玄関 方角、門 風水、表札、傘立て、玄関 絵画、玄関 時計、玄関チェックリスト

### B 財布・色・金運系（~12）
財布の色 風水、風水 財布、金運 色、長財布 風水、小銭入れ、財布 替え時、赤／黄／緑／黒／紺 財布、通帳 保管、財布 置き場所

### C 植物（~15）
サンスベリア 風水、パキラ 風水、観葉植物 風水、虎の尾、お金のなる木、ウンベラータ、ポトス、部屋別おすすめ植物、枯れた植物、寝室 植物、トイレ 植物、方角×植物、植え替え時期、フェイクグリーン可否

### D 部屋・レイアウト（~15）
部屋 風水、寝室 ベッド位置、リビング ソファ、キッチン コンロ、トイレ 風水、洗面所、本棚、デスク位置、クローゼット、間取り チェックリスト、風水 模様替え、北向き部屋、一人暮らし 風水

### E 数字・車・小物（~10）
風水 良い車のナンバー 4桁、電話番号 語呂、名刺 色、印鑑、時計、鏡の置き方、時計の針、カレンダー

### F 工具／實用落地（~10｜P2 預留）
方位かんたん、吉日チェック、部屋チェックリスト、色診断（娯楽）、間取りメモ、FAQ ハブ、用語集、季節の掃除、引越しチェック、免責付き診断 LP

**合計槽位 ≈ 77–80**；可再拆長尾至 100。每條上站前必須自寫，唔貼研究 transcript。

## 4 繁中預留簇（唔當本卡必做）
- TW：辦公室／辦公桌、虎尾蘭、白水木、銅錢草、龜背芋、一命二運三風水
- HK：辦公室、風水師（慎）、富貴竹、電話號碼；**唔做師資排名主打**

## 5 對齊證據（Drive）
- `fengshui_keywords_jp.png`：頭詞「風水」~110K／月；相關 ~40.5K 詞／總量 ~1.2M
- TW／HK PNG：頭詞細，靠工具／清單／本地實用頁
- `douyin_fengshui.txt`：日式住宅尺度／取捨／AI 戶型趣味—**研究 only**

## 6 下一步
1. D5 批後導出正式 Google Sheet（同 schema 欄）。
2. 先填 30 條 `ja` + `status=seed` 大綱。
3. D2 確認前唔開繁中批次生產。
