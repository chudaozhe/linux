require 'mysql2'
client = Mysql2::Client.new(:host => "localhost", :username => "root",:password=>"",:database=>"adstats")
results = client.query("select * from ad_stats");
results.each do |hash|
	puts hash.map { |k,v|"#{k}= #{v}"}.join(", ")
end
