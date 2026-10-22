# 內容管線 Runbook｜風水日站 P0
更新：2026-10-22（Asia/Hong_Kong）｜管家：fengshui｜狀態：草稿可跟

## 0 紅線（先讀）
- **禁止**把抖音／TikTok 原文、片、字幕、封面直接上站。
- 產出只作**主題／結構／關鍵字意圖研究** → 自寫／自產日文（或繁中）內容。
- 付費 Apify transcript Actor（如 `apple_yang/douyin-transcripts-scraper`）**唔用**；改本機 faster-whisper。
- CDN 直鏈會過期；過期再跑免費 metadata／封面，唔囤永久片庫作上站素材。
- 版權／scraped 上站跡象 → **即停上報**大官／方生。

## 1 管線總覽
```
短鏈／aweme URL
  → Apify zen-studio/douyin-video-scraper（免費額度；metadata + cover；唔開 MP4 addon）
  → 本機落盤 meta JSON + cover（必要時暫存 audio／video 僅供 ASR）
  → faster-whisper ASR（研究用 transcript）
  → 主題筆記／關鍵字簇 → 種子 Sheet → 自寫稿
  → 站上只放自寫稿＋免責
```

## 2 Apify（免費 metadata／封面）
- Actor：`zen-studio/douyin-video-scraper`
- 輸入：`v.douyin.com` 短鏈或長鏈
- 期望欄位：`id`／`itemTitle`／`caption`／`authorMeta.name`／`coverUrl`／`durationSeconds`（videoUrl／audioUrl 可選、會過期）
- 煙測（已成功）：run `9a92Icac7HWtiDilI`｜dataset `sy20hXTUIskZqoOuS`｜KV `4ARbgpdx2dRR1py3s`｜2026-10-22 ≈15:14 HKT｜SUCCEEDED ~26s｜1 條
- 操作：Apify MCP `call-actor` → `get-dataset-items`；封面可由 KV／coverUrl 落盤
- 成本紀律：只用免費額度；唔開付費 transcript／唔批量 MP4 addon

## 3 本機 Whisper（box 樣本）
路徑：`/workspace/fengshui-jp-sample/`

| 檔 | 用途 |
| --- | --- |
| `README.txt` | 本機備援說明 |
| `p0_douyin.py` | 短鏈→aweme id；可跟 meta CDN 下載；`--asr` |
| `meta-7636929599577885993.json` | Apify 試驗摘要 |
| `cover-*.jpg`／`audio-*.mp3`／`video-*.mp4` | 煙測資產（唔上站） |
| `transcript-smoke-45s.txt` | tiny 模型 45s ASR |
| `.venv` | faster-whisper 1.2.1 |

一條指令：
```bash
cd /workspace/fengshui-jp-sample
.venv/bin/python p0_douyin.py 'https://v.douyin.com/…' -o . \
  --meta meta-<id>.json --asr --asr-seconds 45 --model tiny
```
- 日站正式研究可改 `--model small`／`medium`（tiny 錯字多）
- 依賴：python3、ffmpeg、numpy、faster-whisper；yt-dlp 無 cookie 常 403，唔作唯一來源

## 4 研究 → 種子（禁止抄）
1. 由 caption／ASR 抽**主題句**（例：玄関、財布色、植物、佈局 checklist）—唔保留原文段落上站。
2. 對齊日站關鍵字簇（見種子草稿）：寫**原創日文**大綱／FAQ／checklist。
3. 來源欄只記 `source_kind=research` + aweme_id（內部），公開頁唔露出抖音鏈／作者名作內容來源。
4. AI 戶型／趣味測試類主題 → 必須強娛樂免責（見免責草稿）。

## 5 入庫建議（待 D6）
- 現階段：Drive Sheet／本 repo `docs/` JSON／md 即可。
- 唔入 LLMWiki vault／唔入公司帳目機密，直至 D6 批。

## 6 驗收 checklist（本卡 P0）
- [x] Apify metadata＋封面煙測成功
- [x] 本機 Whisper 45s 煙測有 transcript
- [ ] 種子 50–100 簇方向表（草稿已出，Sheet 待補）
- [ ] 免責草稿上站欄位就位（草稿已出）
- [ ] 全程無 scraped 文／片上站

## 7 唔做
開通／綁域／AdSense／prod 部署／叫醒元方；派程天／候五郎改站碼（除非另卡已批）。
