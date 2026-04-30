
lines_to_keep = []
with open("user_dashboard.php", "r", encoding="utf-8") as f:
    lines = f.readlines()

start_line = 3578 - 1  # 0-indexed
end_line = 4054 - 1    # 0-indexed (points to MODAL SERTIFIKAT PREMIUM)

# We want to keep everything before start_line
# And everything from end_line onwards
new_content = lines[:start_line] + lines[end_line:]

with open("user_dashboard.php", "w", encoding="utf-8") as f:
    f.writelines(new_content)
